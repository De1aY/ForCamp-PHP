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

    function ArrayToString($Array){  // Преобразование массива в строку
        if(isset($Array)){
            if(count($Array) == 1){
                return "`".$Array[0]."`";
            }
            else{
                $Result = "";
                for($i = 0; $i < count($Array); $i++){
                    $Result += "`".$Array[$i]."`,";    
                }
                $Result =  substr($Result, 0, strlen($Result)-1);
                return $Result;
            }
        }
        else{
            return 600;  // 600 - Строка пуста
        }
    }

    function MySQLResultToArray($Result){  // Преобразование результата запроса в массив
        $ResultArray = array();
        while($Array = mysqli_fetch_assoc($Result)){
            $ResultArray[] = $Array;
        }
        return $ResultArray;
    }

    class DataBase{  // Класс для работы с базой данных
        var $DB;  // Соединение с базой данных

        function BaseInit(){  // Создание подключения к базе данных со стандартными параметрами
            try{
                $this->DB = new mysqli(MYSQL_SERVER, MYSQL_LOGIN, MYSQL_PASSWORD, MYSQL_DB);
                return 200;  // 200 - OK
            }catch(Exception $e){
                return 500;  // 500 - Ошибка при создании подключения к базе данных
            }
        }

        function AdvancedInit($MySQL_Server, $MySQL_Login, $MySQL_Password, $MySQL_DB){  // Создания подключения к базе данных с заданными параметрами
            try{
                $this->DB = new mysqli($MySQL_Server, $MySQL_Login, $MySQL_Password, $MySQL_DB);
                return 200;  // 200 - OK
            }catch(Exception $e){
                return 500;  // 500 - Ошибка при создании подключения к базе данных
            }
        }

        function Count($Table, $Count){  // Подсчёт количества элементов в таблице
            try{
                $Result = mysqli_fetch_assoc($this->DB->query("SELECT COUNT($Count) FROM $Table"))["COUNT($Count)"];
                return $Result;
            }catch(Exception $e){
                error_log("Count() 502 error");
                return 502;  // 502 - Ошибка при выполнении запроса к базе данных
            }
        }

        function CountWhere($Table, $Count, $Where, $Val){  // Подсчёт количества элементов в таблице с условием
            try{
                $Result = mysqli_fetch_assoc($this->DB->query("SELECT COUNT($Count) FROM $Table WHERE $Where='".$this->DB->real_escape_string($Val)."'"))["COUNT($Count)"];
                return $Result;
            }catch(Exception $e){
                error_log("CountWhere() 502 error");
                return 502;  // 502 - Ошибка при выполнении запроса к базе данных
            }
        }

        function Select($Table, $Select, $Where = NULL, $Val = NULL){  // Выборка значений из базы данных с условием $Select - массив
            $String = ArrayToString($Select);
            if($String != 600){
                if(isset($Where) and isset($Val)){
                    try{
                        $Str = "SELECT ".$String." FROM `".$Table."` WHERE ".$Where."='".$this->DB->real_escape_string($Val)."'";
                        $Result = $this->DB->query($Str);
                        return MySQLResultToArray($Result);
                    }catch(Exception $e){
                        error_log("Select() 502 error");
                        return 502;  // 502 - Ошибка при выполнении запроса к базе данных
                    }
                }
                else{
                    try{
                        $Str = "SELECT ".$String." FROM `".$Table."` WHERE";
                        $Result = $this->DB->query($Str);
                        return MySQLResultToArray($Result);
                    }catch(Exception $e){
                        error_log("Select() 502 error");
                        return 502;  // 502 - Ошибка при выполнении запроса к базе данных
                    }
                }
            }
            else{
                return 600; // 600 - Строка пуста
            }
        }

        function Update($Table, $SetName, $SetVal, $Where, $Val){
            if(isset($SetVal) and isset($SetName)){
                try{
                    $this->DB->query("UPDATE $Table SET $SetName='".$this->DB->real_escape_string($SetVal)."' WHERE $Where='".$this->DB->real_escape_string($Val)."'");
                    return 200;  // 200 - OK
                }catch(Exception $e){
                    error_log("Update() 502 error");
                    return 502;  // 502 - Ошибка при выполнении запроса к базе данных
                }
            }
            else{
                return 600;  // 600 - Строка пуста
            }
        }

        function Execute($String){
            try{
                $Result = $this->DB->query($String);
                if(isset($Result)){
                    return $Result;
                }
            }catch(Exception $e){
                error_log("Execute() 502 error");
                return 502;  // 502 - Ошибка при выполнении запроса к базе данных
            }
        }

        function Close(){
            try{
                $this->DB->Close();
                return 200;  // 200 - OK
            }catch(Exception $e){
                return 501;  // 501 - Ошибка при закрытии соединения с базой данных
            }
        }
    }

    class UserAuthorization extends Authorization{
        var $DB;
        var $Platform;
        var $UserLogin;
        var $UserPassword;

        function UserAuthorization($Login = NULL, $Password = NULL, $Platform = NULL){
            $this->DB = new DataBase();
            $Response = $this->DB->BaseInit();
            if($Response == 200){
                if(isset($Login) and isset($Password) and isset($Platform)){
                    $this->UserLogin = $Login;
                    $this->UserPassword = $Password;
                    $this->Platform = $Platform."Token";
                    return 200;  // 200 - OK
                }
                else{
                    return 600;  // 600 - Строка пуста
                }
            }
            else{
                return $Response;
            }
        }

        function UserToken($DBName, $Token){  // Функция заносит значение Token в базу данных
            try{
                $Result = $this->DB->Update($DBName, $this->Platform, $Token, "Login", $this->UserLogin);
                if($Result == 200){
                    return 200;  // 200 - OK
                }
                else{
                    error_log("UserAuthorization->UserToken(Result) error ".$Result);
                    return $Result;
                }
            }
            catch(Exception $e){
                error_log("UserAuthorization->UserToken(Exception) error 502");
                return 502;  // 502 - Ошибка подключения к базе данных
            }
        }

        function GetUserGroup(){  // Получение уровня прав пользователя
            $Array = array("Group");
            $Result = $this->DB->Select(DB_EMPLOYEES, $Array, 'Login', $this->UserLogin);
            if($Result != 600 and $Result != 502){
                return $Result[0]["Group"];
            }
            else{
                error_log("UserAuthorization->GetUserGroup(Result) error ".$Result);
                return $Result;
            }
        }

        function UserCheck(){  //  Функция выводит ошибку 502 если не удасться подключится к базе данных
            $UserGroup = $this->GetUserGroup();
            if($UserGroup != 600 and $UserGroup != 502){
                switch($UserGroup){
                    case 1: 
                        $UserGroup = DB_ADMINISTRATORS;  // Уровень 1 - Администрация
                        break;
                    case 2: 
                        $UserGroup = DB_TUTORS;  // Уровень 2 - Воспитатели
                        break;
                    case 3: 
                        $UserGroup = DB_TEACHERS;  // Уровень 3 - Учителя
                        break;
                    case 4: 
                        $UserGroup = DB_ORGANIZERS;  // Уровень 4 - Педагоги-Организаторы
                        break;
                    case 5: 
                        $UserGroup = DB_STUDENTS;  // Уровень 5 - Ученики
                        break;
                    default: 
                        error_log("UserAuthorization->UserCheck(switch) error 502");
                        return 502;  // 502 - Ошибка при выполнении запроса к базе данных
                }
                $Array = array("Password");
                $Result = $this->DB->Select($UserGroup, $Array, 'Login', $this->UserLogin);
                if($Result != 600 and $Result != 502){
                    if($Result[0]["Password"] == $this->UserPassword){
                        session_start();
                        $ID = session_id();
                        $this->Success($UserGroup, $ID);
                        return 200;
                    }
                    else{
                        error_log("UserAuthorization->UserCheck() error 401");
                        return 401;  // 401 - Неверный логин или пароль
                    } 
                }
                else{
                    error_log("UserAuthorization->UserCheck(Result) error ".$Result);
                    return $Result;
                }
            }
            else{
                error_log("UserAuthorization->UserCheck(UserGroup) error ".$UserGroup);
                return $UserGroup;
            }
        }
    }

    class TokenAuthorization extend Authorization{
        var $DB;
        var $Token;
        var $Platform;
        
        function TokenAuthorization($Token, $Platform){
            $this->DB = new DataBase;
            $Response = $this->DB->BaseInit();
            if($Response == 200){
                if(isset($Token) and isset($Platform)){
                    $this->Token = $Token;
                    $this->Platform = $Platform."Token";
                    return 200;  // 200 - OK
                }
                else{
                    error_log("TokenAuthorization(Token) error ".$Response);
                    return 600;  // 600 - Строка пуста
                }
            }
            else{
                error_log("TokenAuthorization(DB) error ".$Response);
                return $Response;
            }
        }

        function Check(){

        }

    }

    class Authorization{  // Класс для авторизации
        var $Method;
        var $AuthProcess;
        var $DB;  // Класс `DataBase`

        function Authorization($UserLogin = NULL, $UserPassword = NULL, $Token = NULL, $Platform = NULL){
            $this->DB = new DataBase();
            $Resp = $this->DB->BaseInit();
            if($Resp == 200){  // Если подключение создалось
                if(isset($UserLogin) and isset($UserPassword)){
                    $AuthProcess = new UserAuthorization($UserLogin, $UserPassword, $Platform);
                    $this->Method = 1;
                    return 200;  // 200 - OK
                }
                elseif(isset($Token)){
                    $this->Token = new TokenAuthorization($Token, $Platform);
                    $this->Method = 2;
                    return 200;  // 200 - OK
                }
                else{
                    error_log("Authorization error 600");
                    $this->Error(600);
                }
            }
            else{
                error_log("Authorization(DB) error ".$Resp);
                $this->Error($Resp);
            }
        }

        function Start(){
            if($this->Method == 1){
                $this->UserCheckValidation();
            }
            elseif($this->Method == 2){
                $this->TokenCheckValidation();
            }
            else{
                error_log("Authorization->Start(Method) error 600");
                return 600;  // 600 - Строка пуста
            }
        }

        function UserCheckValidation(){
            switch($this->AuthProcess->UserCheck()){
                case 200: return 200;  // 200 - OK
                case 502:
                    $this->Error(502); 
                    return 502;  // 502 - Ошибка при выполнении запроса к базе данных
                case 600:
                    $this->Error(600); 
                    return 600;  // 600 - Строка пуста
                default:
                    $this->Error(401); 
                    return 401;  // 401 - Неверный логин или пароль
            }
        }

        function Success($UserGroup, $Token){
            if($this->AuthProcess->UserToken($UserGroup, $Token) != 502){
                $Array = array("status" => "OK", "token" => $Token, "code" => 200);
                EchoJSON($Array);
                return 200;  // 200 - OK
            }
            else{
                $this->Error(502);
                return 502;  // 502 - Ошибка при выполнении запроса к базе данных
            }
        }

        function Error($ErrorCode){
            $Array = array("status" => "ERROR", "token" => "", "code" => $ErrorCode);
            EchoJSON($Array);
            return 200;  // 200 - OK
        }

        function Close(){
            try{
                $this->AuthProcess->DB->Close();
                return 200;  // 200 - OK
            }
            catch(Exception $e){
                return 501;  // 501 - Ошибка закрытия подключения к базе данных
            }
        }
    }
?>