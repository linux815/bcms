<?php

namespace bcms\classes\Database;

use PDO;
use PDOException;

require_once __DIR__ . '/../Config/Config.php';

class GhostModel
{
    private ?PDO $dbh = null;

    public function __construct()
    {
        try {
            $this->dbh = new PDO(
                "mysql:host=" . HOSTNAME . ";dbname=" . DBNAME,
                USERNAME,
                PASSWORD,
                [
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'",
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                ],
            );
        } catch (PDOException $e) {
            // Лучше выбросить исключение и логировать отдельно
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    /**
     * Добавить сообщение в гостевую книгу
     */
    public function addMessage(string $title, string $email, string $url, string $message): ?string
    {
        $sql = "INSERT INTO ghost (title, email, url, message, date) 
                VALUES (:title, :email, :url, :message, :date)";
        try {
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute([
                ':title' => $title,
                ':email' => $email,
                ':url' => $url,
                ':message' => $message,
                ':date' => date('Y-m-d H:i:s'),
            ]);
            return null;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Удалить сообщение по ID
     */
    public function deleteGhost(int $id): ?string
    {
        $sql = "DELETE FROM ghost WHERE id = :id";
        try {
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute([':id' => $id]);
            return null;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Получить все сообщения из гостевой книги
     * @return array|string
     */
    public function selectGhost(): array|string
    {
        $sql = "SELECT * FROM ghost ORDER BY id DESC";
        try {
            $stmt = $this->dbh->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function __destruct()
    {
        $this->dbh = null;
    }
}