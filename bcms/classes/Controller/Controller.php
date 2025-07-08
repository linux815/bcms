<?php

namespace bcms\classes\Controller;

use RuntimeException;

/**
 * Базовый класс контроллера
 */
abstract class Controller
{
    /**
     * Полная обработка HTTP запроса
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
        // Для переопределения в наследниках
    }

    /**
     * Виртуальный генератор HTML
     */
    protected function onOutput(): void
    {
        // Для переопределения в наследниках
    }

    /**
     * Запрос произведен методом GET?
     */
    protected function isGet(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    /**
     * Запрос произведен методом POST?
     */
    protected function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    /**
     * Генерация HTML кода из шаблона в строку
     *
     * @param string $fileName Путь к файлу шаблона (относительно /bcms)
     * @param array<int|string, mixed> $vars Переменные для шаблона
     * @return string Сгенерированный HTML
     */
    protected function template(string $fileName, array $vars = []): string
    {
        extract($vars, EXTR_OVERWRITE);

        $templatePath = realpath(__DIR__ . '/../../' . $fileName);

        if ($templatePath === false || !is_file($templatePath)) {
            throw new RuntimeException("Шаблон не найден: {$fileName}");
        }

        ob_start();
        include $templatePath;
        return ob_get_clean() ?: '';
    }
}