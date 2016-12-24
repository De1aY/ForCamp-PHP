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
        protected $DataBase_Connection;

        protected function BaseInit(){  // Создание подключения к базе данных со стандартными параметрами
            try{
                $Connection = new mysqli(MYSQL_SERVER, MYSQL_LOGIN, MYSQL_PASSWORD, MYSQL_DB);
                return $Connection;
            }catch (Exception $e){
                return 500;  // 500 - Ошибка при создании подключения к базе данных
            }
        }

        protected function AdvancedInit($MySQL_Server, $MySQL_Login, $MySQL_Password, $MySQL_DB){  // Создания подключения к базе данных с заданными параметрами
            try{
                $Connection = new mysqli($MySQL_Server, $MySQL_Login, $MySQL_Password, $MySQL_DB);
                return $Connection;
            }catch (Exception $e)({
                return 500;  // 500 - Ошибка при создании подключения к базе данных
            }
        }
    }

    class Authorization_Core extends DataBase{
        protected $User_Login = NULL;
        protected $User_Password = NULL;
        protected $User_Platform = NULL;
        protected $User_Token = NULL;
        protected $Status = 200;

        protected function Authorize(){
            if(isset($this->User_Token)){
                $this->Authorize_WithToken();
            }
            else{
                $this->Authorize_WithoutToken();
            }
        }

        private function Authorize_WithToken(){
            $TokenCount = $this->CountToken();
            if($TokenCount == 1){
                return $this->Success();
            }
            else{
                return $this->Error(602, "Authorize_WithToken");
            }
        }

        private function Authorize_WithoutToken(){

        }

        private function Success(){
            session_start();
            while(TRUE){
                session_regenerate_id();
                $Token = session_id();
                $TokenCount = $this->CountToken($Token);
                if($TokenCount == 0){
                    try{
                        $this->DataBase_Connection->query("UPDATE `".DB_EMPLOYEES."` SET (`".$this->User_Platform."`) VALUES ('$Token')");
                    }
                    catch (Exception $e){
                        return $this->Error(501, "Success->Update");  // 501 - Ошибка при выполнении запроса к базе данных
                    }
                }
            }
            $this->DataBase_Connection->query("UPDATE `".DB_EMPLOYEES."` SET (`".$this->User_Platform."`) VALUES (");
        }

        private function SetToken(){

        }

        private function GetUserLogin($Token = NULL){
            if(isset($Token)){
                try{
                    return mysqli_fetch_assoc($this->DataBase_Connection->query("SELECT `Login` FROM `".DB_EMPLOYEES."` WHERE ".$this->User_Platform."='".$this->DataBase_Connection->real_escape_string($Token)."'"))["Login"];
                }
                catch (Exception $e){
                    return $this->Error(501, "GetUserLogin");
                }
            }
            else{
                try{
                    return mysqli_fetch_assoc($this->DataBase_Connection->query("SELECT `Login` FROM `".DB_EMPLOYEES."` WHERE ".$this->User_Platform."='".$this->DataBase_Connection->real_escape_string($this->User_Token)."'"))["Login"];
                }
                catch (Exception $e){
                    return $this->Error(501, "GetUserLogin");
                }
            }
        }

        private function GetUserAccessGroup(){
            
        }

        protected function CountToken($Token = NULL){
            if(isset($Token)){
                return mysqli_fetch_assoc($this->DataBase_Connection->query("SELECT COUNT('ID') FROM `".DB_EMPLOYEES."` WHERE ".$this->User_Platform."='".$this->DataBase_Connection->real_escape_string($Token)."'"))["COUNT('ID')"];
            }
            else{
                return mysqli_fetch_assoc($this->DataBase_Connection->query("SELECT COUNT('ID') FROM `".DB_EMPLOYEES."` WHERE ".$this->User_Platform."='".$this->DataBase_Connection->real_escape_string($this->User_Token)."'"))["COUNT('ID')"];
            }
        }

        protected function Error($ErrorCode, $ErrorStage){
            error_log($ErrorStage." error ".$ErrorCode);
            $Array = array("status" => "ERROR", "token" => "", "code" => $ErrorCode);
            EchoJSON($Array);
            $this->Status = $ErrorCode;
            return $ErrorCode;
        }

        protected function SetDataBaseConnection(){
            $this->DataBase_Connection = $this->BaseInit();
            if($this->DataBase_Connection == 500){
                return $this->Error(500, "Authorize->SetDataBaseConnection");  // 500 - Ошибка при создании подключения к базе данных
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
                    return $this->Error(600, "Authorization_Web");  // 600 - Неверный формат входных данных
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
                    return $this->Error(600, "Authorization_Web");  // 600 - Неверный формат входных данных
                }
            }
        }
    }
?>