<?php namespace classes\controller;

/*
 * Базовый класс контроллера
 */
abstract class Controller
{
    /*
     * Конструктор
     */
    function __construct()
    {
        
    }

    /*
     * Полная обработка HTTP запроса
     */
    public function request()
    {
        $this->onInput();
        $this->onOutput();
    }

    /*
     * Виртуальный обработчик запроса
     */
    protected function onInput()
    {
        
    }

    /*
     * Виртуальный генератор HTML
     */
    protected function onOutput()
    {
        
    }

    /*
     * Запрос произведен методом GET?
     */
    protected function isGet()
    {
        return $_SERVER['REQUEST_METHOD'] == 'GET';
    }

    /*
     * Запрос произведен методом POST?
     */
    protected function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    /*
     * Генерация HTML кода в строку
     */
    protected function template($fileName, $vars = array())
    {
        // Установка переменных для шаблона.
        foreach ($vars as $k => $v) {
            $$k = $v;
        }

        // Генерация HTML в строку.
        ob_start();
        include $fileName;
        return ob_get_clean();
    }
}