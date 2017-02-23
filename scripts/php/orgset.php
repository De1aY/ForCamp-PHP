<?php

require_once "userdata.php";

class Orgset extends UserData
{
    private $User_Password_Decoded = "";

    function Orgset($Token, $Return = FALSE)
    {
        $this->Return = $Return;
        $this->Connect();
        if (isset($Token) and !$this->CheckForMatches($Token)) {
            $this->User_Token = $Token;
            $this->SetUserLogin();
            $this->Request_Login = $this->User_Login;
            $this->SetUserOrganization();
            $this->Select($this->User_Organization);
            $this->Return = TRUE;
            $UserData = $this->GetUserData();
            $this->Return = $Return;
            if ($UserData["accesslevel"] !== "admin") {
                $this->Error(604);
            }
        } else {
            $this->Error(600);
        }
    }

    public function ChangeOrganizationName($OrgName)
    {
        if (!preg_match("/[^(\w)|(\x7F-\xFF)|(\s)]/", $OrgName)) {
            $OrgName = strip_tags($OrgName);
            $OrgName = strtolower($OrgName);
            $OrgName = trim($OrgName);
            $OrgName = EncodeAES($OrgName);
            $Check = $this->Connection->query("UPDATE `dictionary` SET `Value`='" . $OrgName . "' WHERE `Function`='" . FUNCTION_ORGANIZATION . "'");
            if (!$Check) {
                return $this->Error(501);
            } else {
                exit(json_encode(["code" => 200, "status" => "OK"]));
            }
        } else {
            $this->Error(600);
        }
    }

    public function ChangeParticipantName($PartName)
    {
        if (!preg_match("/[^(\w)|(\x7F-\xFF)|(\s)]/", $PartName)) {
            $PartName = strip_tags($PartName);
            $PartName = strtolower($PartName);
            $PartName = trim($PartName);
            $PartName = EncodeAES($PartName);
            $Check = $this->Connection->query("UPDATE `dictionary` SET `Value`='" . $PartName . "' WHERE `Function`='" . FUNCTION_PARTICIPANT . "'");
            if (!$Check) {
                return $this->Error(501);
            } else {
                exit(json_encode(["code" => 200, "status" => "OK"]));
            }
        } else {
            $this->Error(600);
        }
    }

    public function ChangeTeamName($TeamName)
    {
        if (!preg_match("/[^(\w)|(\x7F-\xFF)|(\s)]/", $TeamName)) {
            $TeamName = strip_tags($TeamName);
            $TeamName = strtolower($TeamName);
            $TeamName = trim($TeamName);
            $TeamName = EncodeAES($TeamName);
            $Check = $this->Connection->query("UPDATE `dictionary` SET `Value`='" . $TeamName . "' WHERE `Function`='" . FUNCTION_TEAM . "'");
            if (!$Check) {
                return $this->Error(501);
            } else {
                exit(json_encode(["code" => 200, "status" => "OK"]));
            }
        } else {
            $this->Error(600);
        }
    }

    public function ChangePeriodName($PerName)
    {
        if (!preg_match("/[^(\w)|(\x7F-\xFF)|(\s)]/", $PerName)) {
            $PerName = strip_tags($PerName);
            $PerName = strtolower($PerName);
            $PerName = trim($PerName);
            $PerName = EncodeAES($PerName);
            $Check = $this->Connection->query("UPDATE `dictionary` SET `Value`='" . $PerName . "' WHERE `Function`='" . FUNCTION_PERIOD . "'");
            if (!$Check) {
                return $this->Error(501);
            } else {
                exit(json_encode(["code" => 200, "status" => "OK"]));
            }
        } else {
            $this->Error(600);
        }
    }

    public function EditCategories($Categories)
    {
        if (count($Categories) <= 10) {
            $Resp = $this->Connection->query("DELETE FROM `dictionary` WHERE `Function`='" . FUNCTION_CATEGORY . "'");
            if ($Resp === TRUE) {
                for ($i = 0; $i < 10; $i++) {
                    $this->Connection->query("ALTER TABLE `participants` DROP COLUMN `Cat" . $i . "`");
                }
                for ($i = 0; $i < count($Categories); $i++) {
                    if (!preg_match("/[^(\w)|(\x7F-\xFF)|(\s)]/", $Categories[$i])) {
                        $Resp = $this->Connection->query("INSERT INTO `dictionary`(`Key`,`Value`,`Function`) VALUES ('" . EncodeAES('Cat' . $i) . "','" . EncodeAES(trim(strtolower($Categories[$i]))) . "','" . FUNCTION_CATEGORY . "')");
                        if ($Resp !== TRUE) {
                            $this->Error(501);
                        }
                        $Resp = $this->Connection->query("ALTER TABLE `participants` ADD COLUMN `Cat" . $i . "` INT NOT NULL DEFAULT '0'");
                        if ($Resp !== TRUE) {
                            $this->Error(501);
                        }
                    } else {
                        $this->Error(600);
                    }
                }
                exit(json_encode(["code" => 200, "status" => "OK"]));
            } else {
                $this->Error(501);
            }
        } else {
            $this->Error(600);
        }
    }

    public function AddParticipants(){
        $uploadfile = PATH_FILES.basename($_FILES['uploadfile']['name']);
    }

    public function AddParticipant($Name, $Surname, $MiddleName, $Sex, $Team){
        $this->CheckInputData($Name, $Surname, $MiddleName, $Sex, $Team);
        $Name = EncodeAES(strtolower($Name));
        $Surname = EncodeAES(strtolower($Surname));
        $MiddleName = EncodeAES(strtolower($MiddleName));
        $Sex = EncodeAES(strtolower($Sex));
        $Team = EncodeAES(strtolower($Team));
        $this->AddParticipant_Main();
        $this->Select($this->User_Organization);
        $this->AddParticipant_Organization($Name, $Surname, $MiddleName, $Sex, $Team);
        exit(json_encode(["status"=>"OK", "code"=>200, "login"=>DecodeAES($this->User_Login), "password"=>$this->User_Password_Decoded]));
    }

    private function CheckInputData($Name, $Surname, $Middlename, $Sex, $Team, $Post="test"){
        if (!preg_match("/[^(\w)|(\x7F-\xFF)|(\s)]/", $Name.$Surname.$Middlename.$Sex.$Team.$Post)) {
            $this->CheckParticipantData_Sex($Sex);
        } else {
            exit(json_encode(["status"=>"ERROR", "code"=>600]));
        }
    }

    private function CheckParticipantData_Sex($Sex){
        switch ($Sex){
            case "мужской":
                return TRUE;
            case "женский":
                return TRUE;
            default:
                exit(json_encode(["status"=>"ERROR", "code"=>600]));
        }
    }

    private function AddParticipant_Organization($Name, $Surname, $MiddleName, $Sex, $Team){
        $Resp = $this->Connection->query("INSERT INTO `users`(`Login`, `Name`, `Surname`, `Middlename`, `Sex`, `Team`, `Avatar`, `Accesslevel`)
          VALUES ('$this->User_Login', '$Name', '$Surname', 
          '$MiddleName', '$Sex', '$Team', '".EncodeAES("media/images/avatar_default.jpg")."', '".EncodeAES("participant")."')");
        if(!$Resp){
            exit(json_encode(["status"=>"ERROR", "code"=>501]));
        }
        $Resp = $this->Connection->query("INSERT INTO `participants`(`Login`) VALUES ('$this->User_Login')");
        if(!$Resp){
            exit(json_encode(["status"=>"ERROR", "code"=>501]));
        }
    }

    private function AddParticipant_Main(){
        $this->Select("camp");
        $this->GeneratePassword();
        $CurrentID = $this->Connection->query("SELECT MAX(`ID`) FROM `users`");
        $CurrentID = mysqli_fetch_array($CurrentID)[0]+1;
        if($CurrentID) {
            $this->User_Login = EncodeAES("participant_".$CurrentID);
            $Resp = $this->Connection->query("INSERT INTO `users`(`Login`,`Password`,`Organization`) VALUES('".$this->User_Login."',
          '" . $this->User_Password . "', '" . EncodeAES($this->User_Organization)."')");
            if(!$Resp){
                exit(json_encode(["status"=>"ERROR", "code"=>501]));
            }
        } else {
            exit(json_encode(["status"=>"ERROR", "code"=>501]));
        }
    }

    private function AddEmployee($Name, $Surname, $MiddleName, $Sex, $Team, $Post){
        $this->CheckInputData($Name, $Surname, $MiddleName, $Sex, $Team, $Post);
        $Name = EncodeAES(strtolower($Name));
        $Surname = EncodeAES(strtolower($Surname));
        $MiddleName = EncodeAES(strtolower($MiddleName));
        $Sex = EncodeAES(strtolower($Sex));
        $Team = EncodeAES(strtolower($Team));
        $this->AddEmployee_Main();
        $this->Select($this->User_Organization);
        $this->AddEmployee_Organization($Name, $Surname, $MiddleName, $Sex, $Team, $Post);
        exit(json_encode(["status"=>"OK", "code"=>200, "login"=>DecodeAES($this->User_Login), "password"=>$this->User_Password_Decoded]));
    }

    private function AddEmployee_Main(){
        $this->Select("camp");
        $this->GeneratePassword();
        $CurrentID = $this->Connection->query("SELECT MAX(`ID`) FROM `users`");
        $CurrentID = mysqli_fetch_array($CurrentID)[0]+1;
        if($CurrentID) {
            $this->User_Login = EncodeAES("employee_".$CurrentID);
            $Resp = $this->Connection->query("INSERT INTO `users`(`Login`,`Password`,`Organization`) VALUES('".$this->User_Login."',
          '" . $this->User_Password . "', '" . EncodeAES($this->User_Organization)."')");
            if(!$Resp){
                exit(json_encode(["status"=>"ERROR", "code"=>501]));
            }
        } else {
            exit(json_encode(["status"=>"ERROR", "code"=>501]));
        }
    }

    private function AddEmployee_Organization($Name, $Surname, $MiddleName, $Sex, $Team, $Post){
        $Resp = $this->Connection->query("INSERT INTO `users`(`Login`, `Name`, `Surname`, `Middlename`, `Sex`, `Team`, `Avatar`, `Accesslevel`)
          VALUES ('$this->User_Login', '$Name', '$Surname', 
          '$MiddleName', '$Sex', '$Team', '".EncodeAES("media/images/avatar_default.jpg")."', '".EncodeAES("employee")."')");
        if(!$Resp){
            exit(json_encode(["status"=>"ERROR", "code"=>501]));
        }
    }

    private function GeneratePassword(){
        $this->User_Password_Decoded = random_int(1000000, 9999999);
        $this->User_Password = password_hash($this->User_Password_Decoded, PASSWORD_BCRYPT);
        if($this->User_Password){
            return TRUE;
        }
        exit(json_encode(["code"=> 505, "status"=>"ERROR"]));
    }

}