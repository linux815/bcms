<?php namespace bcms\classes\Database;

use \PDO;
use \PDOException;

require($_SERVER['DOCUMENT_ROOT'].'/bcms/classes/Config/Config.php');

/*
 * 	ToDo:
 * 	1. Прописать комментарии для каждой функции, за что отвечает
 * 	2. Переименовать функции по стандарту
 *  ============================================================
 * 	Стандарт: 
 * 	Название функций будет вида: действие_название_дополнение
 *  Пример: select_page, select_page_id, select_page_count
 *  SQL-запросы будут писаться с больших букв, по стандарту
 *  Пример: SELECT title FROM page WHERE id=1;
 *  Все запросы должны прогоняться через функцию prepare
 */

class DatabaseModel
{

    public function __construct()
    {
        
    }

    public function selectSettings()
    {
        try {

            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

            $sql = "SELECT * FROM settings WHERE id_settings = 1";

            return $dbh->query($sql)->fetch();

            $dbh = NULL;
        } catch (PDOException $e) {
            return "База данных временно не доступна!";
        }
    }

    public function select($table)
    {
        try {

            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

            $sql = "SELECT * FROM $table WHERE $table.delete = 0 and hide=0";

            return $dbh->query($sql);

            $dbh = NULL;
        } catch (PDOException $e) {
            return "База данных временно не доступна!";
        }
    }

    public function selectPageId($id)
    {
        try {

            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

            $sql = "SELECT * FROM page WHERE id_page=?";

            $q = $dbh->prepare($sql);
            $q->execute(array($id));
            
            return $q->fetch();

            $dbh = NULL;
        } catch (PDOException $e) {
            return "База данных временно не доступна!";
        }
    }

    public function selectAllPage($start, $num)
    {
        try {

            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

            $sql = "SELECT *, DATE_FORMAT(date,'%d.%m.%Y') as date FROM page WHERE page.delete = 0 ORDER BY id_page DESC LIMIT $start, $num";
 
            return $dbh->query($sql);

            $dbh = NULL;
        } catch (PDOException $e) {
            return "База данных временно не доступна!";
        }
    }

    public function findAll($field, $text, $table)
    {
        try {

            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

            $sql = "SELECT * FROM $table WHERE $table.$field like '%".$text."%'";

            return $dbh->query($sql);

            $dbh = NULL;
        } catch (PDOException $e) {
            return "База данных временно не доступна!";
        }
    }

    public function addPage($title, $hide)
    {
        try {

            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

            $date = date('Y-m-d');

            $sql = "INSERT INTO `page` (`id_page`, `title`, `text`, `date`, `html`, `delete`, `hide`) VALUES (NULL, :title, '', :date, '0', '0', :hide);";
            $q = $dbh->prepare($sql);
            $q->execute(array(':title' => $title,
                ':date' => $date,
                ':hide' => $hide));

            $dbh = NULL;
        } catch (PDOException $e) {
            return "База данных временно не доступна!";
        }
    }

    public function pageUpdate($id, $title, $text, $html)
    {
        try {

            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

            $date = date('Y-m-d');

            $sql = "UPDATE page
	        SET title=?,text=?,date=?,html=?
	        WHERE id_page=?";

            $q = $dbh->prepare($sql);
            $q->execute(array($title, $text, $date, $html, $id));

            $dbh = NULL;
        } catch (PDOException $e) {
            return "База данных временно не доступна!";
        }
    }

    public function deletePage($id)
    {
        try {

            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD);

            $sql = "UPDATE page
	        SET page.delete=1
	        WHERE id_page=?";

            $q = $dbh->prepare($sql);
            $q->execute(array($id));

            $dbh = NULL; // Закрываем соединение
        } catch (PDOException $e) {
            return "База данных временно не доступна!";
        }
    }

    public function countPage()
    {
        try {
            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

            $sql = "SELECT COUNT(*) as count FROM page where page.delete = 0 ORDER BY id_page ASC";

            return $dbh->query($sql)->fetch();

            $dbh = NULL; // Закрываем соединение
        } catch (PDOException $e) {
            return "База данных временно не доступна!";
        }
    }

    public function selectDel($table, $start, $num)
    {
        try {

            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

            $sql = "SELECT * FROM $table WHERE $table.delete = 1 LIMIT $start, $num";

            return $dbh->query($sql);

            $dbh = NULL;
        } catch (PDOException $e) {
            return "База данных временно не доступна!";
        }
    }

    public function countDel($table)
    {
        try {
            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

            $sql = "SELECT COUNT(*) as count FROM $table WHERE $table.delete = 1 ORDER BY 1 ASC";

            return $dbh->query($sql)->fetch();

            $dbh = NULL; // Закрываем соединение
        } catch (PDOException $e) {
            return "База данных временно не доступна!";
        }
    }

    public function addModulePage($id, $module)
    {
        try {

            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

            $sql = "UPDATE page
	        SET $module=1
	        WHERE id_page=?";

            $q = $dbh->prepare($sql);
            $q->execute(array($id));

            $dbh = NULL;
        } catch (PDOException $e) {
            return "База данных временно не доступна!";
        }
    }

    public function deleteAllModule($id)
    {
        try {

            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

            $sql = "UPDATE page
	        SET news=0, ghost=0, review=0
	        WHERE id_page=?";

            $q = $dbh->prepare($sql);
            $q->execute(array($id));

            $dbh = NULL;
        } catch (PDOException $e) {
            return "База данных временно не доступна!";
        }
    }

    public function updateSettings2($news, $ghost, $review)
    {
        try {

            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

            $sql = "UPDATE settings
	        SET news=?, ghost=?, review=?
	        WHERE id_settings=1";

            $q = $dbh->prepare($sql);
            $q->execute(array($news, $ghost, $review));

            $dbh = NULL;
        } catch (PDOException $e) {
            return "База данных временно не доступна!";
        }
    }

    public function updateSettings($template, $nameSite, $m_users, $md_review, $keywords, $description)
    {
        try {

            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

            $sql = "UPDATE settings
	        SET template=?, namesite=?, m_users=?, md_review=?, keywords=?, description=?
	        WHERE id_settings=1";

            $q = $dbh->prepare($sql);
            $q->execute(array($template, $nameSite, $m_users, $md_review, $keywords, $description));

            $dbh = NULL;
        } catch (PDOException $e) {
            return "База данных временно не доступна!";
        }
    }
    
    public function recoveryRecycleID($id, $table, $table_id)
    {
        try {

            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

            $sql = "UPDATE $table
	        SET $table.delete=0
	        WHERE $table_id=?";

            $q = $dbh->prepare($sql);
            $q->execute(array($id));

            $dbh = NULL; // Закрываем соединение
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function deleteRecycleID($id, $table, $table_id)
    {
        try {

            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

            $sql = "DELETE FROM $table
			WHERE $table_id=?";

            $q = $dbh->prepare($sql);
            $q->execute(array($id));

            $dbh = NULL; // Закрываем соединение
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }    
}