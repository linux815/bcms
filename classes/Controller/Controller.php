<?php

namespace Classes\Controller;

use RuntimeException;

/**
 * Базовый класс контроллера
 */
abstract class Controller
{
    /**
     * Полная обработка HTTP-запроса
     */
    public function request(): void
    {
        $this->onInput();
        $this->onOutput();
    }

    /**
     * Виртуальный обработчик запроса
     */
    protected function onInput(): void
    {
        // Переопределяется в наследниках
    }

    /**
     * Виртуальный генератор HTML
     */
    protected function onOutput(): void
    {
        // Переопределяется в наследниках
    }

    /**
     * Проверяет, что запрос сделан методом GET
     */
    protected function isGet(): bool
    {
        return ($_SERVER['REQUEST_METHOD'] ?? '') === 'GET';
    }

    /**
     * Проверяет, что запрос сделан методом POST
     */
    protected function isPost(): bool
    {
        return ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST';
    }

    /**
     * Генерация HTML из шаблона с переменными
     *
     * @param string $fileName Путь к файлу шаблона относительно корня проекта
     * @param array<string, mixed> $vars Переменные для передачи в шаблон
     *
     * @return string Сгенерированный HTML
     *
     * @throws RuntimeException Если шаблон не найден
     */
    protected function template(string $fileName, array $vars = []): string
    {
        // Извлекаем переменные в область видимости шаблона
        extract($vars, EXTR_OVERWRITE);

        // Приводим путь к абсолютному пути относительно текущей директории
        $templatePath = realpath(__DIR__ . '/../../' . $fileName);

        if ($templatePath === false || !is_file($templatePath)) {
            throw new RuntimeException("Шаблон не найден: {$fileName}");
        }

        ob_start();
        include $templatePath;
        return ob_get_clean() ?: '';
    }
}