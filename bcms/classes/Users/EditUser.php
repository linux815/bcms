<?php
/**
 * EditUser.php — редактирование профиля пользователя
 */

namespace bcms\classes\Users;

use bcms\classes\BaseClass\Base;
use bcms\classes\Database\UserModel;
use DOMDocument;

class EditUser extends Base
{
    protected array $user = [];
    private ?array $userData = null;
    private ?string $error = null;

    protected function onInput(): void
    {
        parent::onInput();

        $this->title = 'Редактирование профиля - ' . $this->title;

        $userModel = UserModel::Instance();
        $this->user = $userModel->Get() ?? [];

        $userId = (int)filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        if (!$userId) {
            header('Location: index.php?c=users');
            exit;
        }

        $this->userData = $userModel->selectUserID($userId);

        if ($this->isPost()) {
            $this->handlePost($userModel, $userId);
        }
    }

    private function handlePost(UserModel $userModel, int $userId): void
    {
        if (isset($_POST['Close'])) {
            header('Location: index.php?c=users');
            exit;
        }

        if (isset($_POST['Delete'])) {
            header('Location: index.php?c=confirm&delete=users&id=' . $userId);
            exit;
        }

        if (isset($_POST['Block'])) {
            echo "<script>alert('Функция будет доступна в будущих версиях.')</script>";
            return;
        }

        if (isset($_POST['SaveInfo'])) {
            $password = trim($_POST['password'] ?? '');
            $passwordApply = trim($_POST['password_apply'] ?? '');

            if ($passwordApply === '') {
                $finalPassword = $this->userData['password'] ?? '';
            } elseif ($password === $passwordApply) {
                $finalPassword = md5($password);
            } else {
                $this->error = 'Пароли не совпадают!';
                return;
            }

            $avatar = $this->extractAvatar($_POST['avatar'] ?? '');

            // Прочие поля
            $fields = [
                'name' => filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'surname' => filter_input(INPUT_POST, 'surname', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
                'lastname' => filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'sex' => filter_input(INPUT_POST, 'sex', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '',
                'city' => filter_input(INPUT_POST, 'city', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'mobile_phone' => filter_input(INPUT_POST, 'mobile_phone', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'work_phone' => filter_input(INPUT_POST, 'work_phone', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'skype' => filter_input(INPUT_POST, 'skype', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'birth_date' => $this->formatDate($_POST['birth_date'] ?? ''),
            ];

            $userModel->editUserInfo(
                $userId,
                $finalPassword,
                $fields['name'],
                $fields['surname'],
                $fields['email'],
                $fields['lastname'],
                $avatar,
                $fields['birth_date'],
                $fields['sex'],
                $fields['city'],
                $fields['mobile_phone'],
                $fields['work_phone'],
                $fields['skype'],
            );

            header("Location: index.php?c=profile&id={$userId}");
            exit;
        }
    }

    private function extractAvatar(string $html): string
    {
        $html = trim($html);
        if ($html === '') {
            return '';
        }

        libxml_use_internal_errors(true);
        $dom = new DOMDocument();

        // Защита от исключения при пустом/некорректном HTML
        if (!@$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD)) {
            libxml_clear_errors();
            return '';
        }

        libxml_clear_errors();

        foreach ($dom->getElementsByTagName('img') as $img) {
            return $img->getAttribute('src');
        }

        // Если <img> не найден, возвращаем чистый текст
        return strip_tags($html);
    }

    private function formatDate(string $date): string
    {
        // Ожидается формат: дд.мм.гггг
        if (preg_match('/^\d{2}\.\d{2}\.\d{4}$/', $date)) {
            return date('Y-m-d', strtotime(str_replace('.', '-', $date)));
        }
        return '';
    }

    protected function onOutput(): void
    {
        $vars = [
            'user' => $this->user,
            'userID' => $this->userData,
            'error' => $this->error,
        ];

        $this->content = $this->template('templates/v_editUser.php', $vars);
        parent::onOutput();
    }
}