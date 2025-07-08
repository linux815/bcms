<?php

namespace bcms\classes\Database;

use PDO;
use PDOException;

require_once __DIR__ . '/../Config/Config.php';

class NewsModel
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
            die('Connection failed: ' . $e->getMessage());
        }
    }

    public function selectNewsId(int $id): array|string
    {
        try {
            $sql = "SELECT *, DATE_FORMAT(date, '%d.%m.%Y') AS date FROM news WHERE id_news = :id";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function selectAllNews(int $start, int $num): array|string
    {
        try {
            $sql = "SELECT *, DATE_FORMAT(date, '%d.%m.%Y') AS date 
                    FROM news 
                    WHERE news.delete = 0 
                    ORDER BY id_news DESC 
                    LIMIT :start, :num";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(':start', $start, PDO::PARAM_INT);
            $stmt->bindValue(':num', $num, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function addNews(string $title, string $text): ?string
    {
        try {
            $sql = "INSERT INTO news (title, text, date, `delete`) 
                    VALUES (:title, :text, :date, 0)";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute([
                ':title' => $title,
                ':text' => $text,
                ':date' => date('Y-m-d H:i:s'),
            ]);
            return null;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function newsUpdate(int $id, string $title, string $text): ?string
    {
        try {
            $sql = "UPDATE news SET title = :title, text = :text, date = :date WHERE id_news = :id";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute([
                ':title' => $title,
                ':text' => $text,
                ':date' => date('Y-m-d H:i:s'),
                ':id' => $id,
            ]);
            return null;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function deleteNews(int $id): ?string
    {
        try {
            $sql = "UPDATE news SET news.delete = 1 WHERE id_news = :id";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute([':id' => $id]);
            return null;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function countNews(): array|string
    {
        try {
            $sql = "SELECT COUNT(*) AS count FROM news WHERE news.delete = 0";
            return $this->dbh->query($sql)->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function __destruct()
    {
        $this->dbh = null;
    }
}