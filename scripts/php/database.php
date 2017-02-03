<?php

require_once 'lib.php';

define("MYSQL_SERVER_REMOTE", "52.169.122.82");  // IP сервера MySQL
define("MYSQL_LOGIN_REMOTE", "root");  // Логин сервера MySQL
define("MYSQL_PASSWORD_REMOTE", "5zaU2x8A");  // Пароль сервера MySQL
define("MYSQL_SERVER", "127.0.0.1");  // IP сервера MySQL
define("MYSQL_LOGIN", "root");  // Логин сервера MySQL
define("MYSQL_PASSWORD", "");  // Пароль сервера MySQL
define("MYSQL_DB", "camp");  // Название базы данных на сервере MySQL

class DataBase
{

    protected $Connection;

    /**
     * @param string $Server
     * @param string $Login
     * @param string $Password
     * @param string $Database
     */
    protected function Connect($Server = MYSQL_SERVER_REMOTE, $Login = MYSQL_LOGIN_REMOTE, $Password = MYSQL_PASSWORD_REMOTE, $Database = MYSQL_DB)
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