<?php

require_once "authorization.php";

class UserData extends Authorization
{
    private $Owner = FALSE;
    private $VerLogin = FALSE;
    protected $Request_Login = NULL;
    protected $User_Organization = NULL;

    /**
     * UserData constructor.
     * @param string $Token
     * @param string $Login
     * @param bool $Return
     * @return UserData
     */
    function UserData($Token, $Login = NULL, $Return = FALSE)
    {
        $this->Return = $Return;
        $this->Connect();
        if (isset($Token) && !$this->CheckForMatches($Token)) {
            $this->User_Token = $Token;
            $this->SetUserLogin();
            $this->SetUserOrganization();
            $this->Select($this->User_Organization);
            $this->Request_Login = isset($Login) ? EncodeAES($Login) : $this->User_Login;
            if ($this->User_Login === $this->Request_Login) {
                $this->Owner = TRUE;
                $this->VerLogin = TRUE;
            } else {
                if($this->CheckUsersOrganization()){
                    $this->VerLogin = TRUE;
                }
            }
        } else {
            $this->Error(600);
        }
    }

    /**
     * @param string $Function
     * @return string
     */
    public function GetValueForViewByFunction($Function)
    {
        $Value = $this->Connection->query("SELECT `Value` FROM `dictionary` WHERE `Function`='" . $this->Connection->real_escape_string($Function) . "'");
        if (!is_bool($Value)) {
            $Value = mysqli_fetch_assoc($Value)["Value"];
            if (is_string($Value)) {
                if ($this->Return === TRUE) {
                    return DecodeAES($Value);
                } else {
                    $this->Close();
                    exit(json_encode(["status" => "OK", "code" => 200, "value" => DecodeAES($Value)]));
                }
            } else {
                $this->Error(501);
            }
        } else {
            $this->Error(501);
        }
    }

    /**
     * @param string $Key
     * @return string
     */
    public function GetValueForViewByKey($Key)
    {
        $Value = $this->Connection->query("SELECT `Value` FROM `dictionary` WHERE `Key`='" . $this->Connection->real_escape_string($Key) . "'");
        if (!is_bool($Value)) {
            $Value = mysqli_fetch_assoc($Value)["Value"];
            if (is_string($Value)) {
                if ($this->Return === TRUE) {
                    return DecodeAES($Value);
                } else {
                    $this->Close();
                    exit(json_encode(["status" => "OK", "code" => 200, "value" => DecodeAES($Value)]));
                }
            } else {
                $this->Error(501);
            }
        } else {
            $this->Error(501);
        }
    }

    public function GetUserLogin()
    {
        if ($this->Return === TRUE) {
            return DecodeAES($this->User_Login);
        } else {
            $this->Close();
            exit(json_encode(["status" => "OK", "code" => 200, "login" => DecodeAES($this->User_Login)]));
        }
    }

    public function GetUserOrganization()
    {
        if ($this->Return === TRUE) {
            return $this->ReturnValueForViewByKey(EncodeAES($this->User_Organization));
        } else {
            $this->Close();
            exit(json_encode(["status" => "OK", "code" => 200, "organization" => $this->ReturnValueForViewByKey(EncodeAES($this->User_Organization))]));
        }
    }

    public function GetUserData()
    {
        if (isset($this->User_Organization)) {
            $Data = $this->Connection->query("SELECT `name`,`surname`,`middlename`,`avatar`,`sex`,`accesslevel`,`team` FROM `users` WHERE `login`='" . $this->Connection->real_escape_string($this->Request_Login) . "'");
            if (!is_bool($Data)) {
                $Data = mysqli_fetch_assoc($Data);
                $Data = array_map("DecodeAES", $Data);
                $Data = array_merge($Data, ["organization" => $this->ReturnValueForViewByKey(EncodeAES($this->User_Organization)), "owner" => $this->Owner]);
                switch ($Data["accesslevel"]){
                    case "participant":
                        $Data = array_merge($Data, $this->GetParticipant());
                        break;
                    case "employee":
                        $Data = array_merge($Data, $this->GetEmployee());
                        break;
                    default:
                        break;
                }
                if (is_array($Data)) {
                    if ($this->Return === TRUE) {
                        return $Data;
                    } else {
                        $this->Close();
                        exit(json_encode(array_merge($Data, ["status" => "OK", "code" => 200])));
                    }
                } else {
                    $this->Error(501);
                }
            } else {
                $this->Error(501);
            }
        } else {
            $this->Error(600);
        }
    }

    public function GetCategories()
    {
        $Categories = $this->Connection->query("SELECT `Key`,`Value` FROM `dictionary` WHERE `Function`='" . FUNCTION_CATEGORY . "'");
        if (!is_bool($Categories)) {
            $Data = array();
            while ($row = mysqli_fetch_assoc($Categories)) {
                $Data = array_merge($Data, [array_map("DecodeAES", $row)]);
            }
            if ($this->Return === TRUE) {
                return array_merge(["val" => count($Data)], $Data);
            } else {
                exit(json_encode(array_merge(["status" => "OK", "code" => 200, "val" => count($Data)], $Data)));
            }
        } else {
            $this->Error(501);
        }
    }

    public function GetUserMarks()
    {
        $Data = [];
        $Categories = $this->ReturnCategories();
        for ($i = 0; $i < count($Categories); $i++) {
            $Data = array_merge($Data, [$Categories[$i] => $this->GetUserMark($Categories[$i])]);
        }
        if (is_array($Data)) {
            return $Data;
        } else {
            $this->Error(501);
        }
    }

    public function CloseSession()
    {
        $this->Select("camp");
        $Close = $this->Connection->query("DELETE FROM `sessions` WHERE `token`='" . $this->Connection->real_escape_string($this->User_Token) . "'");
        if ($Close === TRUE) {
            setcookie("sid", "");
            $this->Close();
            header("location: auth.php");
        } else {
            $this->Error(501);
        }
    }

    public function GetFunctionsValues()
    {
        $Functions = $this->Connection->query("SELECT * FROM `dictionary` WHERE `Function`!='" . FUNCTION_CATEGORY . "'");
        if (!is_bool($Functions)) {
            $Data = array();
            while ($row = mysqli_fetch_assoc($Functions)) {
                $Arr = array_map("DecodeAES", $row);
                $Data[$Arr["Function"]] = $Arr;
            }
            if (is_array($Data)) {
                if ($this->Return === TRUE) {
                    return $Data;
                } else {
                    $this->Close();
                    exit(json_encode(array_merge(["status" => "OK", "code" => 200], $Data)));
                }
            } else {
                $this->Error(501);
            }
        } else {
            $this->Error(501);
        }
    }

    public function GetVerLogin(){
        return $this->VerLogin;
    }

    public function GetParticipants(){
        $Participants = $this->Connection->query("SELECT * FROM `participants`");
        if(is_bool($Participants)){
            exit(json_encode(["status"=>"ERROR", "code"=>501]));
        }
        $Data = [];
        while ($row = mysqli_fetch_assoc($Participants)){
            $tmp = array_merge($row, $this->GetParticipantData($row["Login"]));
            $tmp["Login"] = DecodeAES($tmp["Login"]);
            array_push($Data, $tmp);
        }
        if ($this->Return === TRUE){
            return array_merge($Data, ["val"=> count($Data)]);
        } else {
            exit(json_encode(array_merge(["status" => "OK", "code" => 200, "val" => count($Data)], $Data)));
        }
    }

    public function GetEmployees()
    {
        $Employees = $this->Connection->query("SELECT * FROM `employees`");
        if (is_bool($Employees)) {
            exit(json_encode(["status" => "ERROR", "code" => 501]));
        }
        $Data = [];
        while ($row = mysqli_fetch_assoc($Employees)) {
            $tmp = array_merge($row, $this->GetEmployeesData($row["Login"]));
            $tmp["Login"] = DecodeAES($tmp["Login"]);
            $tmp["Post"] = DecodeAES($tmp["Post"]);
            array_push($Data, $tmp);
        }
        if ($this->Return === TRUE) {
            return array_merge($Data, ["val" => count($Data)]);
        } else {
            exit(json_encode(array_merge(["status" => "OK", "code" => 200, "val" => count($Data)], $Data)));
        }
    }

    public function GetUserOrganization_Eng(){
        if ($this->Return === TRUE) {
            return $this->User_Organization;
        } else {
            $this->Close();
            exit(json_encode(["status" => "OK", "code" => 200, "organization" => $this->ReturnValueForViewByKey(EncodeAES($this->User_Organization))]));
        }
    }

    public function GetEmployee(){
        $Employee = $this->Connection->query("SELECT * FROM `employees` WHERE `Login`='".$this->Connection->real_escape_string($this->Request_Login)."'");
        if (is_bool($Employee)) {
            exit(json_encode(["status" => "ERROR", "code" => 501]));
        }
        $Data = mysqli_fetch_assoc($Employee);
        $Data["Login"] = DecodeAES($Data["Login"]);
        $Data["Post"] = DecodeAES($Data["Post"]);
        return array_merge($Data);
    }

    public function GetParticipant(){
        $Participant = $this->Connection->query("SELECT * FROM `participants` WHERE `Login`='".$this->Connection->real_escape_string($this->Request_Login)."'");
        if (is_bool($Participant)) {
            exit(json_encode(["status" => "ERROR", "code" => 501]));
        }
        $Data = mysqli_fetch_assoc($Participant);
        $Data["Login"] = DecodeAES($Data["Login"]);
        return $Data;
    }

    public function GetActions($ReqLogin = NULL){
        if(isset($ReqLogin)){
            $Response = $this->Connection->query("SELECT * FROM `actions` WHERE `Object`='$ReqLogin' OR `Subject` = '$ReqLogin' ORDER BY `Time` DESC");
            if($Response === FALSE){
                exit(json_encode(["status"=>"ERROR", "code"=>501]));
            }
            $Data = [];
            while($row = mysqli_fetch_assoc($Response)){
                $row["Subject"] = DecodeAES($row["Subject"]);
                $row["Object"] = DecodeAES($row["Object"]);
                $row["Type"] = DecodeAES($row["Type"]);
                $row["Options"] = unserialize(DecodeAES($row["Options"]));
                array_push($Data, $row);
            }
            return $Data;
        } else {
            $Response = $this->Connection->query("SELECT * FROM `actions` ORDER BY `Time` DESC");
            if($Response === FALSE){
                exit(json_encode(["status"=>"ERROR", "code"=>501]));
            }
            $Data = [];
            while($row = mysqli_fetch_assoc($Response)){
                $row["Subject"] = DecodeAES($row["Subject"]);
                $row["Object"] = DecodeAES($row["Object"]);
                $row["Type"] = DecodeAES($row["Type"]);
                $row["Options"] = unserialize(DecodeAES($row["Options"]));
                array_push($Data, $row);
            }
            return $Data;
        }
    }

    protected function SetUserLogin()
    {
        $Login = $this->Connection->query("SELECT `login` FROM `sessions` WHERE `token`='" . $this->Connection->real_escape_string($this->User_Token) . "'");
        if (!is_bool($Login)) {
            $Login = mysqli_fetch_assoc($Login)["login"];
            if (is_string($Login)) {
                $this->User_Login = $Login;
            } else {
                $this->Error(501);
            }
        } else {
            $this->Error(501);
        }
    }

    protected function SetUserOrganization()
    {
        if (isset($this->User_Login)) {
            $Organization = $this->Connection->query("SELECT `organization` FROM `users` WHERE `login`='" . $this->Connection->real_escape_string($this->User_Login) . "'");
            if (!is_null($Organization)) {
                $Organization = mysqli_fetch_assoc($Organization)["organization"];
                if (is_string($Organization)) {
                    $this->User_Organization = DecodeAES($Organization);
                } else {
                    $this->Error(501);
                }
            } else {
                $this->Error(501);
            }
        } else {
            $this->Error(600);
        }
    }

    protected function GetUserMark($Category)
    {
        $Mark = $this->Connection->query("SELECT `" . $Category . "` FROM `participants` WHERE `Login`='" . $this->Connection->real_escape_string($this->Request_Login) . "'");
        if (!is_bool($Mark)) {
            $Mark = mysqli_fetch_all($Mark);
            return $Mark[0][0];
        } else {
            $this->Error(501);
        }
    }

    /**
     * @param string $Key
     * @return string
     */
    protected function ReturnValueForViewByKey($Key)
    {
        $Value = $this->Connection->query("SELECT `Value` FROM `dictionary` WHERE `Key`='" . $this->Connection->real_escape_string($Key) . "'");
        if (!is_bool($Value)) {
            $Value = mysqli_fetch_assoc($Value)["Value"];
            if (is_string($Value)) {
                return DecodeAES($Value);
            }
        }
    }

    protected function CheckUsersOrganization(){
        $Count = $this->Connection->query("SELECT COUNT(`Name`) FROM `users` WHERE `Login`='".$this->Request_Login."'");
        if(!is_bool($Count)){
            $Count = mysqli_fetch_assoc($Count)["COUNT(`Name`)"];
            if($Count > 0){
                return TRUE;
            } else {
                $this->Error(605);
            }
        } else {
            $this->Error(501);
        }
    }

    private function GetParticipantData($Login){
        $Data = $this->Connection->query("SELECT `name`,`surname`,`middlename`,`avatar`,`sex`,`accesslevel`,`team` FROM `users` WHERE `login`='" . $Login . "'");
        if (!is_bool($Data)) {
            $Data = mysqli_fetch_assoc($Data);
            $Data = array_map("DecodeAES", $Data);
            $Data = array_merge($Data, ["organization" => $this->ReturnValueForViewByKey(EncodeAES($this->User_Organization))]);
            return $Data;
        } else {
            exit(json_encode(["status"=>"ERROR", "code"=>501]));
        }
    }

    /**
     * @return array|null
     */
    private function ReturnCategories()
    {
        $Categories = $this->Connection->query("SELECT `Key` FROM `dictionary` WHERE `Function`='" . $this->Connection->real_escape_string(FUNCTION_CATEGORY) . "'");
        if (!is_bool($Categories)) {
            $Categories = mysqli_fetch_all($Categories);
            if (is_array($Categories)) {
                return $Categories;
            } else {
                $this->Error(501);
            }
        } else {
            $this->Error(501);
        }
    }

    private function GetEmployeesData($Login)
    {
        $Data = $this->Connection->query("SELECT `name`,`surname`,`middlename`,`avatar`,`sex`,`accesslevel`,`team` FROM `users` WHERE `login`='" . $Login . "'");
        if (!is_bool($Data)) {
            $Data = mysqli_fetch_assoc($Data);
            $Data = array_map("DecodeAES", $Data);
            $Data = array_merge($Data, ["organization" => $this->ReturnValueForViewByKey(EncodeAES($this->User_Organization))]);
            return $Data;
        } else {
            exit(json_encode(["status" => "ERROR", "code" => 501]));
        }
    }

}