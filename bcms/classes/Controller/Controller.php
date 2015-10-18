<?php 
namespace bcms\classes\Controller;
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
        return filter_input(INPUT_SERVER, 
                            'REQUEST_METHOD', 
                            FILTER_SANITIZE_FULL_SPECIAL_CHARS) == 'GET';
    }

    /*
     * Запрос произведен методом POST?
     */
    protected function isPost()
    {
        return filter_input(INPUT_SERVER, 
                            'REQUEST_METHOD', 
                            FILTER_SANITIZE_FULL_SPECIAL_CHARS) == 'POST';
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