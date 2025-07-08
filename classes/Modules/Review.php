<?php
/*
 * Review.php - отзывы с математической капчей
 */

namespace Classes\Modules;

use bcms\classes\Database\DatabaseModel;
use bcms\classes\Database\ReviewModel;
use Classes\BaseClass\BaseSecond;
use Random\RandomException;

class Review extends BaseSecond
{
    public ?int $error = null; // статус ошибки: null - нет, 1 - капча не пройдена, 2 - успешно

    /*
     * Виртуальный обработчик запроса
     */
    /**
     * @throws RandomException
     */
    protected function onInput(): void
    {
        parent::onInput();

        $reviewModel = new ReviewModel();
        $databaseModel = new DatabaseModel();

        $this->title = 'Обратная связь - ' . $this->title;

        // Загружаем настройки CMS
        $settings = $databaseModel->selectSettings();

        // Генерируем или проверяем капчу
        if (!isset($_SESSION['captcha_num1']) || !isset($_SESSION['captcha_num2'])) {
            $_SESSION['captcha_num1'] = random_int(1, 9);
            $_SESSION['captcha_num2'] = random_int(1, 9);
        }

        if ($this->isPost()) {
            $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $text = trim($_POST['text'] ?? '');
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $captchaInput = filter_input(INPUT_POST, 'captcha', FILTER_SANITIZE_NUMBER_INT);

            // Проверяем капчу: пользовательский ввод vs сумма чисел в сессии
            $correctAnswer = $_SESSION['captcha_num1'] + $_SESSION['captcha_num2'];

            if ($captchaInput !== null && (int)$captchaInput === $correctAnswer) {
                // Капча пройдена
                if (($settings['md_review'] ?? '') === "admin") {
                    $reviewModel->addReview($subject, $text, $name, $email);
                    $this->error = 2; // успех
                } else {
                    mail($settings['email'], $subject, $text);
                    $this->error = 2; // успех
                }
                // Сброс капчи после успешной отправки
                unset($_SESSION['captcha_num1'], $_SESSION['captcha_num2']);
            } else {
                // Капча не пройдена
                $this->error = 1;

                // Генерируем новую капчу
                $_SESSION['captcha_num1'] = random_int(1, 9);
                $_SESSION['captcha_num2'] = random_int(1, 9);
            }
        }
    }

    /*
     * Виртуальный генератор HTML
     */
    protected function onOutput(): void
    {
        $vars = [
            'error' => $this->error,
            'captchaNum1' => $_SESSION['captcha_num1'] ?? 0,
            'captchaNum2' => $_SESSION['captcha_num2'] ?? 0,
        ];
        $this->content = $this->template('templates/' . $this->settings['template'] . '/v_review.php', $vars);
        parent::onOutput();
    }
}