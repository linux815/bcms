<?php namespace bcms\classes\Database;

use \PDO;
use \PDOException;

require($_SERVER['DOCUMENT_ROOT'].'/bcms/classes/Config/Config.php');

class ReviewModel
{
    public function __construct()
    {
        
    }

    public function selectReview()
    {
        try {

            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

            $sql = "SELECT * FROM reviews ORDER BY id_review DESC";

            return $dbh->query($sql);

            $dbh = NULL;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function selectReviewId($id)
    {
        try {

            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

            $sql = "SELECT * FROM reviews where id_review = '$id' ORDER BY id_review DESC";

            return $dbh->query($sql)->fetch();

            $dbh = NULL;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function deleteReview($id)
    {
        try {

            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

            $sql = "DELETE FROM reviews WHERE id_review = ?";
            $q = $dbh->prepare($sql);
            $q->execute(array($id));

            $dbh = NULL;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function addReview($title, $text, $name, $email)
    {
        try {

            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

            $sql = "INSERT INTO `reviews` (`id_review`, `title`, `text`, `name`, `email`) VALUES (NULL, :title, :text, :name, :email);";
            $q = $dbh->prepare($sql);
            $q->execute(array(':title' => $title,
                ':text' => $text,
                ':name' => $name,
                ':email' => $email));

            $dbh = NULL;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

}