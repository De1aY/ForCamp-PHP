<?php
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

    class DataBase_Connection{  // Класс для работы с базой данных
        function BaseInit(){  // Создание подключения к базе данных со стандартными параметрами
            try{
                $Connection = new mysqli(MYSQL_SERVER, MYSQL_LOGIN, MYSQL_PASSWORD, MYSQL_DB);
                return $Connection;  // 200 - OK
            }catch(Exception $e){
                return 500;  // 500 - Ошибка при создании подключения к базе данных
            }
        }

        function AdvancedInit($MySQL_Server, $MySQL_Login, $MySQL_Password, $MySQL_DB){  // Создания подключения к базе данных с заданными параметрами
            try{
                $Connection = new mysqli($MySQL_Server, $MySQL_Login, $MySQL_Password, $MySQL_DB);
                return $Connection;  // 200 - OK
            }catch(Exception $e){
                return 500;  // 500 - Ошибка при создании подключения к базе данных
            }
        }
    }

    class Authorization{
        var $User_Login;
        var $User_Password;
        var $Token = NULL;
        var $Platform;

        function Authorization($Login, $Password, $Platform, $Token = NULL){
            if(isset($Login) and isset($Password) and isset($Platform)){
                $this->$User_Login = $Login;
                $this->$User_Password = $Password;
                $this->$Platform = $Platform."Token";
                if(isset($Token)){
                    $this->$Token = $Token;
                    return 200;  // 200 - OK
                }
                return 200;  //200 - OK
            }
            else{
                $Array = array("status" => "ERROR", "token" => "", "code" => 600);
                EchoJSON($Array);
                return 600;  // 600 - Строка пуста
            }
        }
    }

    class WebAuthorization extends DataBase_Connection{

        function WebAuthorization(){
            $this->$DataBase = $this->BaseInit();
            if($this->$DataBase != 500){
            
            }
            else{
                return $this->$DataBase;
            }
        }

    }

    class MobileAuthorization extends DataBase_Connection{
        
        function MobileAuthorization(){
            $this->$DataBase = $this->BaseInit();
            if($this->$DataBase != 500){
            
            }
            else{
                return $this->$DataBase;
            }
        }
    }
?>