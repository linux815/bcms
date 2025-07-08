<?php

namespace bcms\classes\Database;

use PDO;
use PDOException;

require_once __DIR__ . '/../Config/Config.php';

class ReviewModel
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

    public function selectReview(): array|string
    {
        try {
            $sql = "SELECT * FROM reviews ORDER BY id_review DESC";
            return $this->dbh->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function selectReviewId(int $id): array|string
    {
        try {
            $sql = "SELECT * FROM reviews WHERE id_review = :id LIMIT 1";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function deleteReview(int $id): ?string
    {
        try {
            $sql = "DELETE FROM reviews WHERE id_review = :id";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute([':id' => $id]);
            return null;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function addReview(string $title, string $text, string $name, string $email): ?string
    {
        try {
            $sql = "INSERT INTO reviews (title, text, name, email) 
                    VALUES (:title, :text, :name, :email)";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute([
                ':title' => $title,
                ':text' => $text,
                ':name' => $name,
                ':email' => $email,
            ]);
            return null;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function __destruct()
    {
        $this->dbh = null;
    }
}