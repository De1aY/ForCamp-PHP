<?php
    define("DB_TUTORS", "tutors");  // Воспитатели (Дисциплина)
    define("DB_STUDENTS", "students");  // Ученики 
    define("DB_TEACHERS", "teachers");  // Учителя (Учёба, Дисциплина)
    define("DB_ORGANIZERS", "organizers"); // Педагоги-Организаторы (Культура, Спорт, Дисциплина)
    define("DB_ADMINISTRATORS", "administrators");  // Администраторы сайта 

    require_once 'database.php';  // Класс для подключения к базе данных

    function EchoJSON($Array){  // Вывод в формате JSON, на вход массив (Ключ => Значение)
        echo json_encode($Array);
    }

    class Authorization{  // Класс для авторизации
        var $UserLogin;
        var $UserPassword;
        var $DB;

        function Init($UserLogin, $UserPassword){
            $this->$UserLogin = $UserLogin;
            $this->$UserPassword = md5($UserPassword);
            $this->$DB = db_connect();
        }

        function UserCheck(){  // Return 501 if connection failed
            try{
                $UserCount = mysqli_fetch_assoc($DB->query("SELECT COUNT('Name') FROM `tutor` WHERE `Login`='"
                .$this->$DB->real_escape_string($this->$UserLogin).
                "' AND `Password`='"
                .$this->$DB->real_escape_string($this->$UserPassword).
                "'"))["COUNT('Name')"];
                return $UserCount;
            }
            catch(Exception $e){
                return 501;  // 501 - Database connection error
            }
        }

        function UserCheckValidation(){
            switch(UserCheck()){
                case 1: return TRUE;
                case 501: return 501;  // 501 - Database connection error
                default: return 401;  // 401 - Login or Password is wrong
            }
        }

        function UserToken($Token){
            try{
                $DB->query("UPDATE `".DB_TUTORS."` SET `Token`='$Token' WHERE `Login`='".$DB->real_escape_string($this->$UserLogin)."'");
            }
            catch(Exception $e){
                return 501;  // 501 - Database connection error
            }
        }

        function Success($Token){
            if(UserToken($Token) != 501){
                $this->$DB->Close();
                $Array = array("status" => "OK", "token" => $Token);
                EchoJSON($Array);
            }
            else{
                Error(501);
            }
        }

        function Error($ErrorCode){
            $this->$DB->Close();
            $Array = array("status" => "ERROR", "code" => $ErrorCode);
            EchoJSON($Array);
        }
    }
?>