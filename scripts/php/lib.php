<?php

    /*
    Коды:
    200 - OK
    500 - Ошибка при создании подключения к базе данных
    501 - Ошибка при выполнении запроса к базе данных
    600 - Неверный формат входных данных
    601 - Неверный логин/пароль
    602 - Неверный токен
    */

	define("MYSQL_SERVER", "52.169.122.82");  // IP сервера MySQL
	define("MYSQL_LOGIN", "root");  // Логин сервера MySQL
	define("MYSQL_PASSWORD", "5zaU2x8A");  // Пароль сервера MySQL
	define("MYSQL_DB", "camp");  // Название таблицы на сервере MySQL
    define("DB_TUTORS", "tutors");  // Воспитатели (Дисциплина)|Уровень - 2
    define("DB_STUDENTS", "students");  // Ученики|Уровень - 5
    define("DB_TEACHERS", "teachers");  // Учителя (Учёба, Дисциплина)|Уровень - 3
    define("DB_ORGANIZERS", "organizers");  // Педагоги-Организаторы (Культура, Спорт, Дисциплина)|Уровень - 4
    define("DB_ADMINISTRATORS", "administrators");  // Администраторы сайта|Уровень - 1
    define("DB_EMPLOYEES", "employees");  // Таблица с уровнем разрешений

    function EchoJSON($Array){  // Вывод в формате JSON, на вход массив (Ключ => Значение)
        echo json_encode($Array);
    }

    class DataBase{  // Класс для работы с базой данных
        protected var $DataBase_Connection;

        protected function BaseInit(){  // Создание подключения к базе данных со стандартными параметрами
            try{
                $Connection = new mysqli(MYSQL_SERVER, MYSQL_LOGIN, MYSQL_PASSWORD, MYSQL_DB);
                return $Connection;
            }catch(Exception $e){
                return 500;  // 500 - Ошибка при создании подключения к базе данных
            }
        }

        protected function AdvancedInit($MySQL_Server, $MySQL_Login, $MySQL_Password, $MySQL_DB){  // Создания подключения к базе данных с заданными параметрами
            try{
                $Connection = new mysqli($MySQL_Server, $MySQL_Login, $MySQL_Password, $MySQL_DB);
                return $Connection;
            }catch(Exception $e){
                return 500;  // 500 - Ошибка при создании подключения к базе данных
            }
        }
    }

    class Authorization_Core extends DataBase{
        protected var $User_Login = NULL;
        protected var $User_Password = NULL;
        protected var $User_Platform = NULL;
        protected var $User_Token = NULL;
        protected var $Status = 200;

        protected function Authorize(){
            if(isset($this->User_Token)){
                $this->Authorize_WithToken();
            }
            else{
                $this->Authorize_WithoutToken();
            }
        }

        private function Authorize_WithToken(){
            
        }

        private function Authorize_WithoutToken(){

        }

        protected function PrintError($ErrorCode, $ErrorStage){
            error_log($ErrorStage." error ".$ErrorCode);
            $Array = array("status" => "ERROR", "token" => "", "code" => $ErrorCode);
            EchoJSON($Array);
            $this->Status = $ErrorCode;
            return $ErrorCode;
        }

        protected function SetDataBaseConnection(){
            $this->DataBase_Connection = $this->BaseInit();
            if($this->DataBase_Connection == 500){
                return PrintError(500, "Authorize->SetDataBaseConnection");  // 500 - Ошибка при создании подключения к базе данных
            }
        }
    }

    class Authorization_Web extends Authorization_Core{

        function Authorization_Web($Login = NULL, $Password = NULL, $Token = NULL){
            $this->User_Platform = "WEBToken";
            if(isset($Login) and isset($Password)){
                $this->User_Login = $Login;
                $this->User_Password = $Password;
                $this->SetDataBaseConnection();
            }
            else{
                if(isset($Token)){
                    $this->User_Token = $Token;
                    $this->SetDataBaseConnection();
                }
                else{
                    return PrintError(600, "Authorization_Web");  // 600 - Неверный формат входных данных
                }
            }
        }

    }

    class Authorization_Mobile extends Authorization_Core{

        function Authorization_Mobile($Login = NULL, $Password = NULL, $Token = NULL){
            $this->User_Platform = "WEBToken";
            if(isset($Login) and isset($Password)){
                $this->User_Login = $Login;
                $this->User_Password = $Password;
                $this->SetDataBaseConnection();
            }
            else{
                if(isset($Token)){
                    $this->User_Token = $Token;
                    $this->SetDataBaseConnection();
                }
                else{
                    return PrintError(600, "Authorization_Web");  // 600 - Неверный формат входных данных
                }
            }
        }
    }
?>