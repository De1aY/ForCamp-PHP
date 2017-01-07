<?php

require_once 'lib.php';

define("MYSQL_SERVER_REMOTE", "52.169.122.82");  // IP сервера MySQL
define("MYSQL_LOGIN_REMOTE", "root");  // Логин сервера MySQL
define("MYSQL_PASSWORD_REMOTE", "5zaU2x8A");  // Пароль сервера MySQL
define("MYSQL_SERVER", "127.0.0.1");  // IP сервера MySQL
define("MYSQL_LOGIN", "root");  // Логин сервера MySQL
define("MYSQL_PASSWORD", "");  // Пароль сервера MySQL
define("MYSQL_DB", "camp");  // Название базы данных на сервере MySQL
define("ENCRYPT_METHOD", "AES-256-CTR");  // Метод шифрования для openssl
define("FUNCTION_OTHER", "vd42FKsq9IA=");  // Другие названия
define("FUNCTION_POST", "vKpdAZUzgIA=");  // Названия должностей
define("FUNCTION_TEAM", "u6oyE5MjgIA=");  // Название команд/групп/классов и.т.д.
define("FUNCTION_CATEGORY", "ht8iS6sl2curGgxE");  // Названия категорий
define("FUNCTION_PARTICIPANT", "vKoiApU10depLCURuv+2tg==");  // Названия участников

class DataBase
{

    protected $Connection;

    /**
     * @param string $Server
     * @param string $Login
     * @param string $Password
     * @param string $Database
     */
    protected function Connect($Server = MYSQL_SERVER, $Login = MYSQL_LOGIN, $Password = MYSQL_PASSWORD, $Database = MYSQL_DB)
    {
        $Connection = new mysqli($Server, $Login, $Password, $Database);
        if ($Connection->connect_error) {
            exit(json_encode(["status" => "ERROR", "code" => 500]));
        } else {
            $this->Connection = $Connection;
        }
    }

    /**
     * @param string $DB
     */
    protected function Select($DB)
    {
        if (!$this->Connection->select_db($DB)) {
            exit(json_encode(["status" => "ERROR", "code" => 503]));
        }
    }

    public function Close()
    {
        if (!$this->Connection->Close()) {
            exit(json_encode(["status" => "ERROR", "code" => 502]));
        }
    }

}