<?php namespace bcms\classes\Database;

use \PDO;
use \PDOException;

require($_SERVER['DOCUMENT_ROOT'].'/bcms/classes/Config/Config.php');

class NewsModel
{
    public function __construct()
    {
        
    }

    public function selectNewsId($id)
    {
        try {

            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

            $sql = "SELECT *, DATE_FORMAT(date,'%d.%m.%Y') as date FROM news WHERE id_news='$id'";

            return $dbh->query($sql);

            $dbh = NULL;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function selectAllNews($start, $num)
    {
        try {

            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

            $sql = "SELECT *, DATE_FORMAT(date,'%d.%m.%Y') as date FROM news WHERE news.delete = 0 ORDER BY id_news DESC LIMIT $start, $num";

            return $dbh->query($sql);

            $dbh = NULL;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function addNews($title, $text)
    {
        try {

            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

            $date = date('Y-m-d H:i:s');

            $sql = "INSERT INTO `news` (`id_news`, `title`, `text`, `date`, `delete`) VALUES (NULL, :title, :text, :date, '0');";
            $q = $dbh->prepare($sql);
            $q->execute(array(':title' => $title,
                ':text' => $text,
                ':date' => $date));

            $dbh = NULL;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function newsUpdate($id, $title, $text)
    {
        try {

            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

            $date = date('Y-m-d H:i:s');

            $sql = "UPDATE news
	        SET title=?,text=?,date=?
	        WHERE id_news=?";

            $q = $dbh->prepare($sql);
            $q->execute(array($title, $text, $date, $id));

            $dbh = NULL;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function deleteNews($id)
    {
        try {

            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD);

            $sql = "UPDATE news
	        SET news.delete=1
	        WHERE id_news=?";

            $q = $dbh->prepare($sql);
            $q->execute(array($id));

            $dbh = NULL; // Закрываем соединение
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function сountNews()
    {
        try {
            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

            $sql = "SELECT COUNT(*) as count FROM news where news.delete = 0 ORDER BY id_news ASC";

            return $dbh->query($sql)->fetch();

            $dbh = NULL; // Закрываем соединение
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

}