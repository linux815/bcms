<?php namespace bcms\classes\Database;

use \PDO;
use \PDOException;

require($_SERVER['DOCUMENT_ROOT'].'/bcms/classes/Config/Config.php');

class GhostModel
{
    public function __construct()
    {
        
    }

    public function addMessage($title, $email, $url, $message)
    {
        try {

            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

            $date = date('d.m.Y H:i');

            $sql = "INSERT INTO ghost (title, email, url, message, date) VALUES (:title, :email, :url, :message, :date)";
            $q = $dbh->prepare($sql);
            $q->execute(array(':title' => $title,
                ':email' => $email,
                ':url' => $url,
                ':message' => $message,
                ':date' => $date));

            $dbh = NULL;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function deleteGhost($id)
    {
        try {

            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

            $sql = "DELETE FROM ghost WHERE id = ?";
            $q = $dbh->prepare($sql);
            $q->execute(array($id));

            $dbh = NULL;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function selectGhost()
    {
        try {

            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

            $sql = "SELECT * FROM ghost ORDER BY id DESC";

            return $dbh->query($sql)->fetchAll();

            $dbh = NULL;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}