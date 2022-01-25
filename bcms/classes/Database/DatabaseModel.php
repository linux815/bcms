<?php

declare(strict_types=1);

namespace bcms\classes\Database;

use InvalidArgumentException;
use PDO;
use PDOException;

require_once __DIR__ . '/../Config/Config.php';

class DatabaseModel
{
    private PDO $dbh;

    public function __construct()
    {
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

    public function selectSettings(): array
    {
        return $this->queryFetch('SELECT * FROM `settings` WHERE `id_settings` = 1');
    }

    /**
     * @param string $sql
     * @param array<int|string, mixed> $params
     * @return array|null
     */
    private function queryFetch(string $sql, array $params = []): ?array
    {
        try {
            $stmt = $this->dbh->prepare($sql);
            foreach ($params as $key => $value) {
                $type = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
                $stmt->bindValue(is_int($key) ? $key + 1 : ':' . $key, $value, $type);
            }
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result === false ? null : $result;
        } catch (PDOException $e) {
            throw new PDOException('Ошибка БД: ' . $e->getMessage());
        }
    }

    /**
     * @param string $sql
     * @param array<int|string, mixed> $params
     * @return void
     */
    private function execute(string $sql, array $params = []): void
    {
        try {
            $stmt = $this->dbh->prepare($sql);
            foreach ($params as $key => $value) {
                $type = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
                $stmt->bindValue(is_int($key) ? $key + 1 : ':' . $key, $value, $type);
            }
            $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException('Ошибка БД: ' . $e->getMessage());
        }
    }

    public function select(string $table): array
    {
        $sql = sprintf('SELECT * FROM `%1$s` WHERE `%1$s`.`delete` = 0 AND `hide` = 0', $table);
        return $this->queryFetchAll($sql);
    }

    /**
     * @param string $sql
     * @param array<int|string, mixed> $params
     * @param array<int|string, mixed> $paramTypes
     * @return array
     */
    private function queryFetchAll(string $sql, array $params = [], array $paramTypes = []): array
    {
        try {
            $stmt = $this->dbh->prepare($sql);

            foreach ($params as $key => $value) {
                if (isset($paramTypes[$key])) {
                    $type = $paramTypes[$key];
                } elseif (is_int($value)) {
                    $type = PDO::PARAM_INT;
                } else {
                    $type = PDO::PARAM_STR;
                }

                if (is_int($key)) {
                    $param = $key + 1;
                } else {
                    $param = ':' . $key;
                }

                $stmt->bindValue($param, $value, $type);
            }

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException('Ошибка БД: ' . $e->getMessage());
        }
    }

    public function selectPageId(int $id): ?array
    {
        $sql = 'SELECT * FROM `page` WHERE `id_page` = :id';
        return $this->queryFetch($sql, ['id' => $id]);
    }

    public function selectAllPage(int $start, int $num): array
    {
        $sql = 'SELECT *, DATE_FORMAT(`date`, "%d.%m.%Y") as date FROM `page` WHERE `delete` = 0 ORDER BY `id_page` DESC LIMIT :start, :num';
        return $this->queryFetchAll($sql, ['start' => $start, 'num' => $num], [PDO::PARAM_INT, PDO::PARAM_INT]);
    }

    public function findAll(string $field, string $text, string $table): array
    {
        $sql = sprintf('SELECT * FROM `%s` WHERE `%s`.`%s` LIKE :text', $table, $table, $field);
        return $this->queryFetchAll($sql, ['text' => "%$text%"]);
    }

    public function addPage(string $title, int $hide): void
    {
        $sql = 'INSERT INTO `page` (`title`, `text`, `date`, `html`, `delete`, `hide`) VALUES (:title, "", :date, 0, 0, :hide)';
        $params = ['title' => $title, 'date' => date('Y-m-d'), 'hide' => $hide];
        $this->execute($sql, $params);
    }

    public function pageUpdate(int $id, string $title, string $text, int $html): void
    {
        $sql = 'UPDATE `page` SET `title` = :title, `text` = :text, `date` = :date, `html` = :html WHERE `id_page` = :id';
        $params = ['title' => $title, 'text' => $text, 'date' => date('Y-m-d'), 'html' => $html, 'id' => $id];
        $this->execute($sql, $params);
    }

    public function deletePage(int $id): void
    {
        $sql = 'UPDATE `page` SET `delete` = 1 WHERE `id_page` = :id';
        $this->execute($sql, ['id' => $id]);
    }

    public function countPage(): int
    {
        $sql = 'SELECT COUNT(*) as count FROM `page` WHERE `delete` = 0';
        $result = $this->queryFetch($sql);
        return (int)($result['count'] ?? 0);
    }

    public function countUsers(): int
    {
        $sql = 'SELECT COUNT(*) as count FROM users';
        $result = $this->queryFetch($sql);
        return (int)($result['count'] ?? 0);
    }

    public function countNews(): int
    {
        $sql = 'SELECT COUNT(*) as count FROM news WHERE `delete` = 0';
        $result = $this->queryFetch($sql);
        return (int)($result['count'] ?? 0);
    }

    public function countGhost(): int
    {
        $sql = 'SELECT COUNT(*) as count FROM ghost';
        $result = $this->queryFetch($sql);
        return (int)($result['count'] ?? 0);
    }

    public function countReviews(): int
    {
        $sql = 'SELECT COUNT(*) as count FROM reviews';
        $result = $this->queryFetch($sql);
        return (int)($result['count'] ?? 0);
    }

    public function selectDel(string $table, int $start, int $num): array
    {
        $sql = sprintf('SELECT * FROM `%s` WHERE `delete` = 1 LIMIT :start, :num', $table);
        return $this->queryFetchAll($sql, ['start' => $start, 'num' => $num], [PDO::PARAM_INT, PDO::PARAM_INT]);
    }

    public function countDel(string $table): int
    {
        $sql = sprintf('SELECT COUNT(*) as count FROM `%s` WHERE `delete` = 1', $table);
        $result = $this->queryFetch($sql);
        return (int)($result['count'] ?? 0);
    }

    public function addModulePage(int $id, string $module): void
    {
        if (!in_array($module, ['news', 'ghost', 'review'], true)) {
            throw new InvalidArgumentException('Недопустимый модуль');
        }

        $sql = "UPDATE `page` SET `$module` = 1 WHERE `id_page` = :id";
        $this->execute($sql, ['id' => $id]);
    }

    public function deleteAllModule(int $id): void
    {
        $sql = 'UPDATE `page` SET `news` = 0, `ghost` = 0, `review` = 0 WHERE `id_page` = :id';
        $this->execute($sql, ['id' => $id]);
    }

    public function updateSettings2(int $news, int $ghost, int $review): void
    {
        $sql = 'UPDATE `settings` SET `news` = :news, `ghost` = :ghost, `review` = :review WHERE `id_settings` = 1';
        $params = ['news' => $news, 'ghost' => $ghost, 'review' => $review];
        $this->execute($sql, $params);
    }

    public function updateSettings(
        string $template,
        string $nameSite,
        int $mUsers,
        string $mdReview,
        string $keywords,
        string $description,
    ): void {
        $sql = 'UPDATE `settings` SET `template` = :template, `namesite` = :nameSite, `m_users` = :mUsers, `md_review` = :mdReview, `keywords` = :keywords, `description` = :description WHERE `id_settings` = 1';
        $params = [
            'template' => $template,
            'nameSite' => $nameSite,
            'mUsers' => $mUsers,
            'mdReview' => $mdReview,
            'keywords' => $keywords,
            'description' => $description,
        ];
        $this->execute($sql, $params);
    }

    public function recoveryRecycleID(int $id, string $table, string $tableId): void
    {
        $sql = sprintf('UPDATE `%s` SET `delete` = 0 WHERE `%s` = :id', $table, $tableId);
        $this->execute($sql, ['id' => $id]);
    }

    public function deleteRecycleID(int $id, string $table, string $tableId): void
    {
        $sql = sprintf('DELETE FROM `%s` WHERE `%s` = :id', $table, $tableId);
        $this->execute($sql, ['id' => $id]);
    }
}