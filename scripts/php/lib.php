<?php

    /*
    Коды:
    200 - OK
    400 - Ошибка при создании сессии
    401 - Ошибка при генерации id сессии
    402 - Ошибка при сохранении сессии
    500 - Ошибка при создании подключения к базе данных
    501 - Ошибка при выполнении запроса к базе данных
    502 - Ошибка при закрытии соединения с базой данных
    600 - Неверный формат входных данных
    601 - Неверный логин/пароль
    602 - Неверный токен
    603 - Пользователя с таким логином не существует
    */

    define("ENCRYPT_METHOD", "AES-256-CTR");  // Метод шифрования для openssl
    define("MYSQL_SERVER", "52.169.122.82");  // IP сервера MySQL
    define("MYSQL_LOGIN", "root");  // Логин сервера MySQL
    define("MYSQL_PASSWORD", "5zaU2x8A");  // Пароль сервера MySQL
    define("MYSQL_DB", "camp");  // Название базы данных на сервере MySQL
    define("DB_USERS", "users");  // Таблица со всеми пользователями
    define("DB_EMPLOYEES", "employees");  // Уровни доступа пользователей
    define("DB_DICTIONARY", "dictionary");  // Таблица с названиями для вывода 
    define("FUNCTION_OTHER", "vd42FKsq9IA=");
    define("FUNCTION_POST", "vKpdAZUzgIA=");
    define("FUNCTION_TEAM", "u6oyE5MjgIA=");
    define("FUNCTION_CATEGORY", "ht8iS6sl2curGgxE");
    define("FUNCTION_PARTICIPANT", "vKoiApU10depLCURuv+2tg==");

    class Requests{

        function CheckToken($Token, $Platform, $Return = TRUE){  // Проверка токена, возвращает код(200/500/...)
            switch ($Platform) {
                case 'WEB':
                    $Auth = new Authorization_Web(NULL, NULL, $Token, $Return);
                    if($Auth->Status == 200){
                        return $Auth->Authorize();
                    }
                    break;
                case 'MOBILE':
                    $Auth = new Authorization_Mobile(NULL, NULL, $Token, $Return);
                    if($Auth->Status == 200){
                        return $Auth->Authorize();
                    }
                    break;
                default:
                    $Auth = new Authorization_Web();
                    break;
            }
        }

        function GetUserData($Token, $Platform, $Login){
            if($this->CheckToken($Token, $Platform)){
                switch($Platform){
                    case "WEB":
                        $Data = new Data_User($Token, $Platform, $Login);
                        if($Data->Status == 200){
                            $Data->GetUserData();
                        }
                        break;
                    case "MOBILE":
                        $Data = new Data_User($Token, $Platform, $Login);
                        if($Data->Status == 200){
                            $Data->GetUserData();
                        }
                        break;
                    default:
                        $Data = new Data_User(NULL, NULL, NULL);
                        break;
                }
            }
        }

        function GetUserOrganization($Token, $Platform, $Login){
            if($this->CheckToken($Token, $Platform)){
                switch($Platform){
                    case "WEB":
                        $Data = new Data_User($Token, $Platform, $Login);
                        if($Data->Status == 200){
                            $Data->GetUserOrg();
                        }
                        break;
                    case "MOBILE":
                        $Data = new Data_User($Token, $Platform, $Login);
                        if($Data->Status == 200){
                            $Data->GetUserOrg();
                        }
                        break;
                    default:
                        $Data = new Data_User(NULL, NULL, NULL);
                        break;
                }
            }
        }

        function GetUserLogin($Token, $Platform){
            if($this->CheckToken($Token, $Platform)){
                switch($Platform){
                case "WEB":
                    $Data = new Authorization_Web(NULL, NULL, $Token);
                    if($Data->Status == 200){
                        $Data->GetUserID();
                    }
                    break;
                case "MOBILE":
                    $Data = new Authorization_Mobile(NULL, NULL, $Token);
                    if($Data->Status == 200){
                        $Data->GetUserID();
                    }
                    break;
                default:
                    $Data = new Data_User(NULL, NULL, NULL);
                    break;
                }
            }
        }
    }

    function EchoJSON($Array){  // Вывод в формате JSON, на вход массив (Ключ => Значение)
        echo json_encode($Array);
    }

    function EncodeAES($str){
        $SecretKey = "bb62afd41e03935f138221d05aeca1a4847c0c154fad323b3a09c8128054a4d7";
        $Salt = "f59761522aaf0cf9";
        $str = base64_encode($str);
        $EncStr = openssl_encrypt($str, ENCRYPT_METHOD, $SecretKey, OPENSSL_ZERO_PADDING, $Salt);
        return $EncStr;
    }

    function DecodeAES($str){
        $SecretKey = "bb62afd41e03935f138221d05aeca1a4847c0c154fad323b3a09c8128054a4d7";
        $Salt = "f59761522aaf0cf9";
        $str = openssl_decrypt($str, ENCRYPT_METHOD, $SecretKey, OPENSSL_ZERO_PADDING, $Salt);
        $str = base64_decode($str);
        return $str;
    }

    function GetMD5($str){
        try{
            $Salt = "f59761522aaf0cf9";
            $hash = md5(md5($str.$Salt).$Salt);
            return $hash;
        }
        catch (Exception $e){
            return 600;  // 600 - Неверный формат входных данных
        }
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
            }catch (Exception $e){
                return 500;  // 500 - Ошибка при создании подключения к базе данных
            }
        }
    }

    class Authorization_Core extends DataBase{
        var $User_Login = NULL;
        var $User_Password = NULL;
        var $User_Platform = NULL;
        var $User_Token = NULL;
        var $Status = 200;
        var $Return = FALSE;

        function Authorize(){
            if(isset($this->User_Token)){
                return $this->Authorize_WithToken();
            }
            else{
                return $this->Authorize_WithoutToken();
            }
        }

        private function Authorize_WithToken(){
            if($this->CountToken() == 1){
                return $this->Success();
            }
            else{
                return $this->Error(602, "Authorize_WithToken");
            }
        }

        private function Authorize_WithoutToken(){
            if(isset($this->User_Login) and isset($this->User_Password)){
                if($this->CheckAuthInf() == 1){
                    $this->GetToken();
                    if($this->Status == 200){
                        return $this->Success();
                    }
                }
                else{
                    return $this->Error(601, "Authorize_WithoutToken");
                }
            }
            else{
                return $this->Error(600, "CheckAuthInf");  // 600 - Неверный формат входных данных
            }
        }

        private function GetToken(){
            try{
                session_start();
            }
            catch (Exception $e){
                return $this->Error(400, "GetToken");  // 400 - Ошибка при создании сессии
            }
            while (TRUE){
                $Token = $this->GenerateToken(session_id());
                if($this->CountToken($Token) == 0){
                    $this->User_Token = $Token;
                    try{
                        $this->DataBase_Connection->query("UPDATE `".DB_USERS."` SET `".$this->User_Platform."`='$Token' WHERE `Login`='".$this->DataBase_Connection->real_escape_string($this->User_Login)."'");
                        break;
                    }
                    catch (Exception $e){
                        return $this->Error(501, "GetToken");  // 501 - Ошибка при выполнении запроса к базе данных
                    }
                }
            }
            try{
                $_SESSION['Token'] = $this->User_Token;
                session_write_close();
            }
            catch (Exception $e){
                return $this->Error(402, "GetToken");  // 402 - Ошибка при сохранении сессии
            }
        }

        private function GenerateToken($SessionID){
            $Salt = "f59761522aaf0cf9";
            $Token = md5(md5($this->User_Login.$this->User_Password.$this->User_Platform.$Salt).md5(time().md5(rand(0, PHP_INT_MAX))).md5($SessionID));
            return $Token;
        }

        private function Success(){
            if($this->Return){
                if($this->CloseDataBaseConnection() == 200){
                    return TRUE;
                }
                else{
                    return FALSE;
                }
            }
            else{
                $Array = array("status" => "OK", "token" => $this->User_Token, "code" => 200);
                EchoJSON($Array);
                if($this->CloseDataBaseConnection() == 200){
                    return 200;  // 200 - OK
                }
                else{
                    return 502;
                }
            }
        }

        function GetUserLogin($Token = NULL){
            if(isset($Token)){
                $Login = mysqli_fetch_assoc($this->DataBase_Connection->query("SELECT `Login` FROM `".DB_USERS."` WHERE ".$this->User_Platform."='".$this->DataBase_Connection->real_escape_string($Token)."'"))["Login"];
                if(isset($Login)){
                    return $Login;
                }
                else{
                    return $this->Error(501, "GetUserLogin");
                }
            }
            else{
                $Login = mysqli_fetch_assoc($this->DataBase_Connection->query("SELECT `Login` FROM `".DB_USERS."` WHERE ".$this->User_Platform."='".$this->DataBase_Connection->real_escape_string($this->User_Token)."'"))["Login"];
                if(isset($Login)){
                    return $Login;
                }
                else{
                    return $this->Error(501, "GetUserLogin");
                }
            }
        }

        private function CheckAuthInf(){
            $Check = mysqli_fetch_assoc($this->DataBase_Connection->query("SELECT COUNT('ID') FROM `".DB_USERS."` WHERE `Login`='".$this->DataBase_Connection->real_escape_string($this->User_Login)."' AND `Password`='".$this->DataBase_Connection->real_escape_string($this->User_Password)."'"))["COUNT('ID')"];
            return $Check;
        }

        protected function CountToken($Token = NULL){
            if(isset($Token)){
                $Count = mysqli_fetch_assoc($this->DataBase_Connection->query("SELECT COUNT('ID') FROM `".DB_USERS."` WHERE ".$this->User_Platform."='".$this->DataBase_Connection->real_escape_string($Token)."'"))["COUNT('ID')"];
                return $Count;
            }
            else{
                $Count = mysqli_fetch_assoc($this->DataBase_Connection->query("SELECT COUNT('ID') FROM `".DB_USERS."` WHERE ".$this->User_Platform."='".$this->DataBase_Connection->real_escape_string($this->User_Token)."'"))["COUNT('ID')"];
                return $Count;
            }
        }

        protected function Error($ErrorCode, $ErrorStage){
            $Array = array("status" => "ERROR", "token" => "", "code" => $ErrorCode);
            EchoJSON($Array);
            $this->Status = $ErrorCode;
            $this->CloseDataBaseConnection();
            if($this->Return){
                return FALSE;
            }
            else{
                return $ErrorCode;
            }
        }

        protected function SetDataBaseConnection(){
            $this->DataBase_Connection = $this->BaseInit();
            if($this->DataBase_Connection == 500){
                return $this->Error(500, "Authorize->SetDataBaseConnection");  // 500 - Ошибка при создании подключения к базе данных
            }
        }

        protected function CloseDataBaseConnection(){
            try{
                $this->DataBase_Connection->Close();
                return 200;
            }
            catch (Exception $e){
                return $this->Error(502, "CloseDataBaseConnection");  // 502 - Ошибка при закрытии соединения с базой данных
            }
        }
    }

    class Authorization_Web extends Authorization_Core{

        function Authorization_Web($Login = NULL, $Password = NULL, $Token = NULL, $Return = FALSE){
            $this->User_Platform = "WEBToken";
            $this->SetDataBaseConnection();
            $this->Return = $Return;
            if(isset($Login) and isset($Password)){
                $this->User_Login = EncodeAES($Login);
                $this->User_Password = GetMD5($Password);
            }
            else{
                if(isset($Token)){
                    $this->User_Token = $Token;
                }
                else{
                    return $this->Error(600, "Authorization_Web");  // 600 - Неверный формат входных данных
                }
            }
        }

        function GetUserID(){
            $Login = DecodeAES($this->GetUserLogin());
            if ($Login != 501){
                EchoJSON(array("login" => $Login, "status" => "OK", "code" => 200));
            }
            $this->CloseDataBaseConnection();
        }
    }

    class Authorization_Mobile extends Authorization_Core{

        function Authorization_Mobile($Login = NULL, $Password = NULL, $Token = NULL, $Return = FALSE){
            $this->User_Platform = "MOBILEToken";
            $this->SetDataBaseConnection();
            $this->Return = $Return;
            if(isset($Login) and isset($Password)){
                $this->User_Login = EncodeAES($Login);
                $this->User_Password = GetMD5($Password);
            }
            else{
                if(isset($Token)){
                    $this->User_Token = $Token;
                }
                else{
                    return $this->Error(600, "Authorization_Web");  // 600 - Неверный формат входных данных
                }
            }
        }

        function GetUserID(){
            $Login = DecodeAES($this->GetUserLogin());
            if ($Login != 501){
                EchoJSON(array("login" => $Login, "status" => "OK", "code" => 200));
            }
            $this->CloseDataBaseConnection();
        }
    }

    class Data_Core extends Authorization_Core{
        var $User_Organization = NULL;

        protected function SetUserOrganization(){
            $this->User_Organization = $this->GetUserOrganization();
            if($this->Status == 200){
                return 200;
            }
        }

        private function GetUserOrganization(){  // Получение организации пользователя по логину
            if(isset($this->User_Token)){
                $Organization = mysqli_fetch_assoc($this->DataBase_Connection->query("SELECT `Organization` FROM `".DB_USERS."` WHERE `Login`='".$this->DataBase_Connection->real_escape_string($this->User_Login)."'"))["Organization"];
                return DecodeAES($Organization);
            }
            else{
                return $this->Error(600, "GetUserOrganization");
            }
        }

        protected function SetDataBaseConnection_Advanced(){
            $this->DataBase_Connection = $this->AdvancedInit(MYSQL_SERVER, MYSQL_LOGIN, MYSQL_PASSWORD, $this->User_Organization);
            $this->User_Organization = EncodeAES($this->User_Organization);
            if($this->DataBase_Connection == 500){
                return $this->Error(500, "SetDataBaseConnection_Advanced");  // 500 - Ошибка при создании подключения к базе данных
            }
        }

        function GetUserAccess(){
            EchoJSON(array_merge(mysqli_fetch_assoc($this->DataBase_Connection->query("SELECT `AccessLevel` FROM `".DB_EMPLOYEES."` WHERE `Login`='".$this->DataBase_Connection->real_escape_string($this->User_Login)."'")), array("status" => "OK", "code" => 200)));
            $this->CloseDataBaseConnection();
        }

        protected function GetValueForView($Data){
            $Val = mysqli_fetch_assoc($this->DataBase_Connection->query("SELECT `Value` FROM `".DB_DICTIONARY."` WHERE `Key`='".$this->DataBase_Connection->real_escape_string($Data)."'"))["Value"];
            $Val = DecodeAES($Val);
            return $Val;
        }
    }

    class Data_User extends Data_Core{
        var $Owner = FALSE;

        function Data_User($Token, $Platform, $Login){
            $this->SetDataBaseConnection();
            if($this->Status == 200){
                if(isset($Token) and isset($Platform) and isset($Login)){
                    $this->User_Login = EncodeAES($Login);
                    if($this->CheckLogin() == 200){
                        $this->User_Token = $Token;
                        $this->User_Platform = $Platform."Token";
                        if($this->GetUserLogin() == $this->User_Login){
                            $this->Owner = TRUE;
                        }
                        $this->SetUserOrganization();
                        $this->CloseDataBaseConnection();
                        $this->SetDataBaseConnection_Advanced();
                    }
                }
                else{
                    return $this->Error(600, "Data_User");
                }
            }
            else{
                return $this->Error(500, "Data_User");
            }
        }

        private function CheckLogin(){
            $Resp = mysqli_fetch_assoc($this->DataBase_Connection->query("SELECT COUNT('ID') FROM `".DB_USERS."` WHERE `Login`='".$this->DataBase_Connection->real_escape_string($this->User_Login)."'"))["COUNT('ID')"];
            if($Resp == 1){
                return 200;
            }
            else{
                return $this->Error(603, "CheckLogin");
            }
        }

        function GetUserData(){
            $Array = array_map("DecodeAES", mysqli_fetch_assoc($this->DataBase_Connection->query("SELECT `Name`,`Surname`,`Middlename`,`Sex`,`Avatar` FROM `".DB_EMPLOYEES."` WHERE `Login`='".$this->DataBase_Connection->real_escape_string($this->User_Login)."'")));
            EchoJSON(array_merge($Array, array("status" => "OK", "code" => 200, "owner" => $this->Owner)));
            $this->CloseDataBaseConnection();
        }

        function GetUserOrg(){
            if($this->Status == 200){
                EchoJSON(array("organization" => $this->GetValueForView($this->User_Organization), "status" => "OK", "code" => 200));
                $this->CloseDataBaseConnection();
            }
        }
    }

?>