<?php

declare(strict_types=1);

namespace bcms\classes\Database;

use PDO;
use PDOException;
use Random\RandomException;

require_once __DIR__ . '/../Config/Config.php';

class UserModel
{
    private static ?UserModel $instance = null;

    private PDO $dbh;
    private ?string $sid = null;
    private ?int $uid = null;

    private function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->connect();
    }

    private function connect(): void
    {
        $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8', HOSTNAME, DBNAME);
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        try {
            $this->dbh = new PDO($dsn, USERNAME, PASSWORD, $options);
        } catch (PDOException $e) {
            throw new PDOException('Ошибка подключения к БД: ' . $e->getMessage());
        }
    }

    public static function Instance(): UserModel
    {
        if (self::$instance === null) {
            self::$instance = new UserModel();
        }
        return self::$instance;
    }

    public function clearSessions(): int
    {
        $min = date('Y-m-d H:i:s', time() - 60 * 15);
        $sql = 'DELETE FROM `sessions` WHERE `time_last` < :min';
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(['min' => $min]);
        return $stmt->rowCount();
    }

    /**
     * @param string $sql
     * @param array<int|string, mixed> $params
     * @return void
     */
    private function execute(string $sql, array $params = []): void
    {
        $stmt = $this->dbh->prepare($sql);
        foreach ($params as $key => $value) {
            $type = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $stmt->bindValue(is_int($key) ? $key + 1 : ':' . $key, $value, $type);
        }
        $stmt->execute();
    }

    public function login(string $login, string $password, bool $remember = true): bool
    {
        $user = $this->getByLogin($login);
        if ($user === null) {
            return false;
        }
        // Внимание: md5 не безопасен для паролей! Лучше использовать password_hash
        if ($user['password'] !== md5($password)) {
            return false;
        }
        if ($remember) {
            $expire = time() + 3600 * 24 * 100;
            setcookie('login', $login, $expire, '/');
            setcookie('password', md5($password), $expire, '/');
        }
        $this->sid = $this->openSession((int)$user['id_user']);
        return true;
    }

    public function getByLogin(string $login): ?array
    {
        $sql = 'SELECT * FROM `users` WHERE `login` = :login';
        return $this->queryFetch($sql, ['login' => $login]);
    }

    /**
     * @param string $sql
     * @param array<int|string, mixed> $params
 * @return array|null
     */
    private function queryFetch(string $sql, array $params = []): ?array
    {
        $stmt = $this->dbh->prepare($sql);
        foreach ($params as $key => $value) {
            $type = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $stmt->bindValue(is_int($key) ? $key + 1 : ':' . $key, $value, $type);
        }
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result === false ? null : $result;
    }

    private function openSession(int $idUser): string
    {
        $sid = $this->generateStr(10);
        $now = date('Y-m-d H:i:s');

        $sql = 'INSERT INTO `sessions` (`id_user`, `sid`, `time_start`, `time_last`) VALUES (:id_user, :sid, :time_start, :time_last)';
        $this->execute($sql, [
            'id_user' => $idUser,
            'sid' => $sid,
            'time_start' => $now,
            'time_last' => $now,
        ]);

        $_SESSION['sid'] = $sid;
        return $sid;
    }

    /**
     * @throws RandomException
     */
    private function generateStr(int $length = 10): string
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789';
        $code = '';
        $maxIndex = strlen($chars) - 1;

        for ($i = 0; $i < $length; $i++) {
            $code .= $chars[random_int(0, $maxIndex)];
        }

        return $code;
    }

    public function logout(): void
    {
        setcookie('login', '', time() - 3600, '/');
        setcookie('password', '', time() - 3600, '/');
        unset($_COOKIE['login'], $_COOKIE['password'], $_SESSION['sid']);
        $this->sid = null;
        $this->uid = null;
    }

    public function get(?int $idUser = null): ?array
    {
        if ($idUser === null) {
            $idUser = $this->getUid();
        }
        if ($idUser === null) {
            return null;
        }
        $sql = 'SELECT * FROM `users` WHERE `id_user` = :id';
        return $this->queryFetch($sql, ['id' => $idUser]);
    }

    public function getUid(): ?int
    {
        if ($this->uid !== null) {
            return $this->uid;
        }
        $sid = $this->getSid();
        if ($sid === null) {
            return null;
        }
        $sql = 'SELECT `id_user` FROM `sessions` WHERE `sid` = :sid';
        $result = $this->queryFetch($sql, ['sid' => $sid]);
        if (empty($result)) {
            return null;
        }
        $this->uid = (int)$result['id_user'];
        return $this->uid;
    }

    private function getSid(): ?string
    {
        if ($this->sid !== null) {
            return $this->sid;
        }
        $sid = $_SESSION['sid'] ?? null;

        if ($sid !== null) {
            $now = date('Y-m-d H:i:s');
            $sql = 'UPDATE `sessions` SET `time_last` = :now WHERE `sid` = :sid';
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(['now' => $now, 'sid' => $sid]);

            if ($stmt->rowCount() === 0) {
                $sqlCheck = 'SELECT COUNT(*) as count FROM `sessions` WHERE `sid` = :sid';
                $result = $this->queryFetch($sqlCheck, ['sid' => $sid]);
                if (empty($result) || $result['count'] == 0) {
                    $sid = null;
                }
            }
        }

        if ($sid === null && isset($_COOKIE['login'], $_COOKIE['password'])) {
            $user = $this->getByLogin($_COOKIE['login']);
            if ($user !== null && $user['password'] === $_COOKIE['password']) {
                $sid = $this->openSession((int)$user['id_user']);
            }
        }

        $this->sid = $sid;
        return $sid;
    }

    /** Получить всех пользователей кроме указанного ID */
    public function listExcept(int $idUser): array
    {
        $sql = 'SELECT * FROM `users` WHERE `id_user` <> :id AND `delete` = 0';
        return $this->queryFetchAll($sql, ['id' => $idUser]);
    }

    /**
     * @param string $sql
     * @param array<int|string, mixed> $params
     * @param array<int|string, mixed> $paramTypes
     * @return array
     */
    private function queryFetchAll(string $sql, array $params = [], array $paramTypes = []): array
    {
        $stmt = $this->dbh->prepare($sql);
        foreach ($params as $i => $value) {
            $type = $paramTypes[$i] ?? (is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
            $stmt->bindValue(is_int($i) ? $i + 1 : ':' . $i, $value, $type);
        }
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLoginCount(string $login): int
    {
        $sql = 'SELECT COUNT(*) as count FROM `users` WHERE `login` = :login';
        $result = $this->queryFetch($sql, ['login' => $login]);
        return (int)($result['count'] ?? 0);
    }

    public function isOnlineExcept(?int $idUser = null): array
    {
        if ($idUser === null) {
            $idUser = $this->getUid();
        }
        if ($idUser === null) {
            return [];
        }
        $sql = 'SELECT n.id_user, c.id_user, c.login, c.avatar, c.name
                FROM `sessions` n
                INNER JOIN `users` c ON n.id_user = c.id_user
                WHERE n.id_user <> :id
                GROUP BY n.id_user
                ORDER BY n.id_user';
        return $this->queryFetchAll($sql, ['id' => $idUser]);
    }

    public function selectUser(int $start, int $num): array
    {
        $sql = 'SELECT * FROM `users` WHERE `delete` = 0 ORDER BY `id_user` ASC LIMIT :start, :num';
        return $this->queryFetchAll($sql, ['start' => $start, 'num' => $num], [PDO::PARAM_INT, PDO::PARAM_INT]);
    }

    public function selectUserSession(int $idUser): array
    {
        $sql = 'SELECT * FROM `sessions` WHERE `id_user` = :id ORDER BY `id_user` ASC';
        return $this->queryFetchAll($sql, ['id' => $idUser]);
    }

    public function selectUserID(int $idUser): ?array
    {
        $sql = "SELECT *, DATE_FORMAT(`birth_date`, '%d.%m.%Y') as birth_date FROM `users` WHERE `id_user` = :id";
        return $this->queryFetch($sql, ['id' => $idUser]);
    }

    public function countUser(): int
    {
        $sql = 'SELECT COUNT(*) as count FROM `users` WHERE `delete` = 0';
        $result = $this->queryFetch($sql);
        return (int)($result['count'] ?? 0);
    }

    public function deleteUser(int $id): void
    {
        $sql = 'UPDATE `users` SET `delete` = 1 WHERE `id_user` = :id';
        $this->execute($sql, ['id' => $id]);
    }

    public function deleteUserALL(): void
    {
        $sql = 'UPDATE `users` SET `delete` = 1 WHERE `id_user` > 1';
        $this->execute($sql);
    }

    public function editUserInfo(
        int $id,
        string $password,
        string $name,
        string $surname,
        string $email,
        string $lastname,
        string $avatar,
        string $birthDate,
        string $sex,
        string $city,
        string $mobilePhone,
        string $workPhone,
        string $skype,
    ): void {
        $sql = 'UPDATE `users` SET 
            `password` = :password, 
            `name` = :name, 
            `surname` = :surname, 
            `email` = :email, 
            `lastname` = :lastname, 
            `avatar` = :avatar,
            `birth_date` = :birth_date, 
            `sex` = :sex, 
            `city` = :city, 
            `mobile_phone` = :mobile_phone, 
            `work_phone` = :work_phone, 
            `skype` = :skype 
            WHERE `id_user` = :id';

        $params = [
            'password' => $password,
            'name' => $name,
            'surname' => $surname,
            'email' => $email,
            'lastname' => $lastname,
            'avatar' => $avatar,
            'birth_date' => $birthDate,
            'sex' => $sex,
            'city' => $city,
            'mobile_phone' => $mobilePhone,
            'work_phone' => $workPhone,
            'skype' => $skype,
            'id' => $id,
        ];

        $this->execute($sql, $params);
    }
}