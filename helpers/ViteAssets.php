<?php

declare(strict_types=1);

namespace App\Helpers;

use Exception;

/**
 * Класс для работы с ассетами, собранными Vite.
 *
 * Поддерживает JS и CSS-ресурсы на основе manifest.json.
 */
final class ViteAssets
{
    /**
     * Путь к манифест-файлу.
     */
    private string $manifestPath;

    /**
     * Базовый публичный URL к ассетам (например, /assets/).
     */
    private string $basePath;

    /**
     * Распарсенный манифест.
     *
     * @var array<string, mixed>|null
     */
    private ?array $manifest = null;

    /**
     * @param string $manifestPath Путь к manifest.json на файловой системе
     * @param string $basePath Публичный URL к ассетам (по умолчанию /assets/)
     */
    public function __construct(string $manifestPath, string $basePath = '/assets/')
    {
        $this->manifestPath = $manifestPath;
        $this->basePath = rtrim($basePath, '/') . '/';
    }

    /**
     * Получить путь к JS/CSS-ассету по ключу.
     *
     * @param string $entryName Ключ, например "js/main.js" или "css/main.css"
     * @return string URL до ассета
     * @throws Exception
     */
    public function asset(string $entryName): string
    {
        $this->loadManifest();

        if (!isset($this->manifest[$entryName]['file'])) {
            throw new Exception(sprintf('Asset "%s" not found in Vite manifest.', $entryName));
        }

        return $this->basePath . $this->manifest[$entryName]['file'];
    }

    /**
     * Загружает manifest.json из файловой системы.
     *
     * @throws Exception
     */
    private function loadManifest(): void
    {
        if ($this->manifest !== null) {
            return;
        }

        if (!is_file($this->manifestPath)) {
            throw new Exception(sprintf('Vite manifest not found: %s', $this->manifestPath));
        }

        $content = file_get_contents($this->manifestPath);
        if ($content === false) {
            throw new Exception(sprintf('Failed to read Vite manifest: %s', $this->manifestPath));
        }

        $decoded = json_decode($content, true);
        if (!is_array($decoded)) {
            throw new Exception(sprintf('Invalid JSON in Vite manifest: %s', $this->manifestPath));
        }

        $this->manifest = $decoded;
    }

    /**
     * Получить <link rel="stylesheet"> для CSS-файлов, связанных с entry.
     *
     * @param string $entryName Ключ CSS или JS entry
     * @return string HTML-теги <link>
     * @throws Exception
     */
    public function css(string $entryName): string
    {
        $this->loadManifest();

        if (empty($this->manifest[$entryName])) {
            return '';
        }

        $cssFiles = [];

        // Vite может генерировать массив css[] (если это JS entry)
        if (!empty($this->manifest[$entryName]['css']) && is_array($this->manifest[$entryName]['css'])) {
            $cssFiles = $this->manifest[$entryName]['css'];
        }

        // Или это может быть CSS entry с file: *.css
        if (empty($cssFiles) && isset($this->manifest[$entryName]['file']) && str_ends_with(
                $this->manifest[$entryName]['file'],
                '.css',
            )) {
            $cssFiles[] = $this->manifest[$entryName]['file'];
        }

        $links = '';
        foreach ($cssFiles as $cssFile) {
            $links .= sprintf(
                '<link rel="stylesheet" href="%s">%s',
                htmlspecialchars($this->basePath . $cssFile, ENT_QUOTES, 'UTF-8'),
                PHP_EOL,
            );
        }

        return $links;
    }
}