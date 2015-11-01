<?php namespace bcms\classes\Database;

use \PDO;
use \PDOException;
use \bcms\classes\Database\UserModel;

require($_SERVER['DOCUMENT_ROOT'].'/bcms/classes/Config/Config.php');

/*
 * Менеджер пользователей
 * =======================
 * ToDo v1.02: 
 * 	1. Проверить функцию IsOnlain, возможно работает не правильно.
 * 	2. Проверить дубликаты функций.
 */
class UserModel
{

    private static $instance; // экземпляр класса
    private $msql;    // драйвер БД
    private $sid;    // идентификатор текущей сессии
    private $uid;    // идентификатор текущего пользователя

    /*
     * Получение экземпляра класса
     * ============================
     * Результат - экземпляр класса MSQL
     */
    public static function Instance()
    {
        if (self::$instance == null)
            self::$instance = new UserModel();

        return self::$instance;
    }

    /*
     * Конструктор
     */
    public function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $this->sid = null;
        $this->uid = null;
    }

    /*
     * Очистка неиспользуемых сессий
     */
    public function clearSessions()
    {
        try {

            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD);

            $min = date('Y-m-d H:i:s', time() - 60 * 15);
            $t = "time_last < '%s'";
            $where = sprintf($t, $min);
            $sql = "DELETE FROM sessions WHERE $where";

            return $dbh->exec($sql);

            $dbh = NULL; // Закрываем соединение	
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /*
     * Авторизация
     * ==============
     * $login - Логин
     * $password - Пароль
     * $remember - Нужно ли запомнить в куках
     * Результат - true или false
     */
    public function login($login, $password, $remember = true)
    {
        // вытаскиваем пользователя из БД 
        $user = $this->getByLogin($login);

        if ($user == null) {
            return false;
        }

        $id_user = $user['id_user'];

        // проверяем пароль
        if ($user['password'] != md5($password)) {
            return false;
        }

        // запоминаем имя и md5(пароль)
        if ($remember) {
            $expire = time() + 3600 * 24 * 100;
            setcookie('login', $login, $expire);
            setcookie('password', md5($password), $expire);
        }

        // открываем сессию и запоминаем SID
        $this->sid = $this->openSession($id_user);

        return true;
    }

    /*
     * Выход
     */
    public function logout()
    {
        setcookie('login', '', time() - 1);
        setcookie('password', '', time() - 1);
        unset($_COOKIE['login']);
        unset($_COOKIE['password']);
        unset($_SESSION['sid']);
        $this->sid = null;
        $this->uid = null;
    }

    /*
     * Получение пользователя
     * ==========================
     * $id_user - Если не указан, брать текущего
     * Результат - Объект польвателя
     */
    public function get($id_user = null)
    {
        try {
            // Если id_user не указан, берем его по текущей сессии.
            if ($id_user == null) {
                $id_user = $this->getUid();
            }

            if ($id_user == null) {
                return null;
            }

            // А теперь просто возвращаем пользователя по id_user.
            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

            $sql = "SELECT * FROM users WHERE id_user = '$id_user'";

            return $dbh->query($sql)->fetch();

            $dbh = NULL; // Закрываем соединение	
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /*
     * Получает пользователя по логину
     */
    public function getByLogin($login)
    {
        try {
            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD);

            $sql = "SELECT * FROM users WHERE login = '$login'";

            return $dbh->query($sql)->fetch();

            $dbh = NULL; // Закрываем соединение
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function loging($id_user)
    {
        try {
            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD);

            $sql = "SELECT * FROM users WHERE id_user <> '$id_user'";

            return $dbh->query($sql);

            $dbh = NULL; // Закрываем соединение
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getLogin($id_user)
    {
        try {
            // А теперь просто возвращаем пользователя по id_user.
            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD);

            $sql = "SELECT COUNT(*) FROM users WHERE login = '$id_user'";

            return $dbh->query($sql)->fetch();

            $dbh = NULL; // Закрываем соединение	
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /*
     * Проверка наличия привилегии
     * ==============================
     * $priv 		- Имя привилегии
     * $id_user		- Если не указан, значит, для текущего
     * Результат	- true или false
     */
    public function can($id_user = null)
    {
        try {
            // Если id_user не указан, берем его по текущей сессии.
            if ($id_user == null)
                $id_user = $this->getUid();

            if ($id_user == null)
                return null;

            // А теперь просто возвращаем пользователя по id_user.
            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD);

            $sql = "SELECT COUNT(*) AS count, id_user FROM sessions GROUP BY id_user ORDER BY id_user";

            return $dbh->query($sql);

            $dbh = NULL; // Закрываем соединение	
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /*
     * Проверка активности пользователя
     * ==================================
     * $id_user		- Идентификатор
     * Результат	- true если online
     */
    public function isOnline($id_user = null)
    {
        try {
            // Если id_user не указан, берем его по текущей сессии.
            if ($id_user == null)
                $id_user = $this->getUid();

            if ($id_user == null)
                return null;

            // А теперь просто возвращаем пользователя по id_user.
            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD);

            //$sql = "SELECT users.login, sessions.id_user FROM users, sessions WHERE users.id_user = sessions.id_user GROUP BY users.login HAVING sessions.id_user > '0'";
            $sql = "SELECT n.id_user , c.id_user, c.login, c.avatar, c.name FROM sessions n INNER JOIN users c ON n.id_user = c.id_user WHERE n.id_user <> '$id_user' GROUP BY n.id_user ORDER BY n.id_user ";

            return $dbh->query($sql);

            $dbh = NULL; // Закрываем соединение	
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /*
     * Получение id текущего пользователя
     * ====================================
     * Результат - UID
     */
    public function getUid()
    {
        try {
            // Проверка кеша.
            if ($this->uid != null)
                return $this->uid;

            // Берем по текущей сессии.
            $sid = $this->getSid();

            if ($sid == null)
                return null;

            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD);

            $sql = "SELECT id_user FROM sessions WHERE sid = '$sid'";

            $result = $dbh->query($sql)->fetch();

            // Если сессию не нашли - значит пользователь не авторизован.
            if (count($result) == 0)
                return null;

            // Если нашли - запоминм ее.
            $this->uid = $result['id_user'];

            return $this->uid;

            $dbh = NULL; // Закрываем соединение	
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /*
     * Функция возвращает идентификатор текущей сессии
     * ================================================
     * Результат - SID
     */
    private function getSid()
    {
        try {
            // Проверка кеша.
            if ($this->sid != null)
                return $this->sid;

            // Ищем SID в сессии.
            if (isset($_SESSION['sid'])) {
                $sid = $_SESSION['sid'];
            } else {
                $sid = null;
            }

            // Если нашли, попробуем обновить time_last в базе. 
            // Заодно и проверим, есть ли сессия там.
            if ($sid != null) {
                $session = array();
                $session = date('Y-m-d H:i:s');
                $t = "sid = '%s'";
                //$affected_rows = $this->msql->Update('sessions', $session, $where);
                $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

                $sql = "UPDATE sessions
	        SET time_last=?
	        WHERE sid=?";

                $q = $dbh->prepare($sql);
                $q->execute(array($session, $sid));

                $affected_rows = $q->rowCount();

                $dbh = NULL; // Закрываем соединение	

                if ($affected_rows == 0) {
                    //	$t = "SELECT count(*) FROM sessions WHERE sid = '%s'";		
                    //	$query = sprintf($t, mysql_real_escape_string($sid));
                    // $result = $this->msql->Select($query);

                    $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD);

                    $sql = "SELECT count(*) FROM sessions WHERE sid = '$sid'";

                    $result = $dbh->query($sql)->fetch();

                    $dbh = NULL; // Закрываем соединение	

                    if ($result['count(*)'] == 0)
                        $sid = null;
                }
            }

            // Нет сессии? Ищем логин и md5(пароль) в куках.
            // Т.е. пробуем переподключиться.
            if ($sid == null && isset($_COOKIE['login'])) {
                $user = $this->GetByLogin($_COOKIE['login']);

                if ($user != null && $user['password'] == $_COOKIE['password'])
                    $sid = $this->OpenSession($user['id_user']);
            }

            // Запоминаем в кеш.
            if ($sid != null)
                $this->sid = $sid;

            // Возвращаем, наконец, SID.
            return $sid;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /*
     * Открытие новой сессии
     * ======================
     * Результат - SID
     */
    private function openSession($id_user)
    {
        // генерируем SID
        $sid = $this->generateStr(10);

        // вставляем SID в БД
        $now = date('Y-m-d H:i:s');
        $session = array();
        $session['id_user'] = $id_user;
        $session['sid'] = $sid;
        $session['time_start'] = $now;
        $session['time_last'] = $now;
     //   $session['online'] = "Онлайн";

        try {
            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

            $sql = "INSERT INTO sessions (id_user, sid, time_start, time_last) VALUES ('$id_user','$sid','$now','$now')";
            $q = $dbh->exec($sql);

            $dbh = NULL; // Закрываем соединение	
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        //$this->msql->Insert('sessions', $session); 
        // регистрируем сессию в PHP сессии
        $_SESSION['sid'] = $sid;

        // возвращаем SID
        return $sid;
    }

    /*
     * Генерация случайной последовательности
     * =======================================
     * $length 		- Ее длина
     * Результат	- Случайная строка
     */
    private function generateStr($length = 10)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;

        while (strlen($code) < $length)
            $code .= $chars[mt_rand(0, $clen)];

        return $code;
    }

    /*
     * ======================================================================================
     * ==Работа с пользователями==
     * ======================================================================================
     */
    /*
     * Получает пользователя по логину
     */
    public function selectUser($start, $num)
    {
        try {
            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

            $sql = "SELECT * FROM users WHERE users.delete = 0 ORDER BY id_user ASC LIMIT $start, $num";

            return $dbh->query($sql)->fetchAll();

            $dbh = NULL; // Закрываем соединение
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /*
     * Проверяем когда был пользователь в онлайне и был ли он там
     */
    public function selectUserSession($id_user)
    {
        try {
            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

            $sql = "SELECT * FROM sessions WHERE sessions.id_user= $id_user ORDER BY id_user ASC";

            return $dbh->query($sql)->fetch();

            $dbh = NULL; // Закрываем соединение
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /*
     * Получает пользователя по id_user
     */
    public function selectUserID($id_user)
    {
        try {
            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

            $sql = "SELECT *, DATE_FORMAT(birth_date,'%d.%m.%Y') as birth_date FROM users WHERE id_user = $id_user";

            return $dbh->query($sql)->fetch();

            $dbh = NULL; // Закрываем соединение
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function countUser()
    {
        try {
            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

            $sql = "SELECT COUNT(*) as count FROM users where users.delete = 0 ORDER BY id_user ASC";

            return $dbh->query($sql)->fetch();

            $dbh = NULL; // Закрываем соединение
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function deleteUser($id)
    {
        try {

            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

            $sql = "UPDATE users
			SET users.delete=1
			WHERE id_user=?";

            $q = $dbh->prepare($sql);
            $q->execute(array($id));

            $dbh = NULL; // Закрываем соединение
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function deleteUserALL()
    {
        try {

            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD);

            $sql = "UPDATE users
	        SET users.delete=1
	        WHERE id_user>1";

            $q = $dbh->prepare($sql);
            $q->execute(array());

            $dbh = NULL; // Закрываем соединение
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function editUserInfo($id, $password, $name, $surname, $email, $lastname, $avatar, $birth_date, $sex, $city, $mobile_phone, $work_phone, $skype)
    {
        try {

            $dbh = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

            $sql = "UPDATE users
	        SET password=?, name=?, surname=?, email=?, lastname=?, avatar=?, birth_date=?, sex=?, city=?, mobile_phone=?, work_phone=?, skype=?
	        WHERE id_user=?; COMMIT;";

            $q = $dbh->prepare($sql);
            $q->execute(array($password, $name, $surname, $email, $lastname, $avatar, $birth_date, $sex, $city, $mobile_phone, $work_phone, $skype, $id));

            $dbh = NULL; // Закрываем соединение
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /*
      public function SelectRecycleCount()
      {
      try {
      $dbh = new PDO("mysql:host=".HOSTNAME.";dbname=".DBNAME."", USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

      $sql = "SELECT SUM(cnt)
      FROM
      (
      SELECT COUNT(*) AS cnt FROM page where page.delete = '1'
      UNION
      SELECT COUNT(*) AS cnt FROM users where users.delete = '1'
      UNION
      SELECT COUNT(*) AS cnt FROM news where news.delete = '1'
      ) AS t";

      return $dbh->query($sql);

      $dbh = NULL; // Закрываем соединение
      }
      catch (PDOException $e)
      {
      return $e->getMessage();
      }
      } */
}