<?php

require_once "userdata.php";
require_once "phpexcel/PHPExcel.php";
require_once "phpexcel/PHPExcel/Writer/Excel2007.php";
require_once "phpexcel/PHPExcel/IOFactory.php";


class Orgset extends UserData
{
    private $User_Password_Decoded = "";

    function Orgset($Token, $Return = FALSE, $Mark = FALSE)
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
            if ($UserData["accesslevel"] !== "admin" && $Mark === FALSE) {
                $this->Error(604);
            } else {
                if ($UserData["accesslevel"] == "participant") {
                    $this->Error(604);
                }
            }
        } else {
            $this->Error(600);
        }
    }

    public function ChangeOrganizationName($OrgName)
    {
        if (!preg_match("/[^(\w)|(\x7F-\xFF)|(\s)]/", $OrgName)) {
            $OrgName = strip_tags($OrgName);
            $OrgName = mb_strtolower($OrgName);
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
            $PartName = mb_strtolower($PartName);
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
            $TeamName = mb_strtolower($TeamName);
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
            $PerName = mb_strtolower($PerName);
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
                    $this->Connection->query("ALTER TABLE `employees` DROP COLUMN `Cat" . $i . "`");
                }
                for ($i = 0; $i < count($Categories); $i++) {
                    if (!preg_match("/[^(\w)|(\x7F-\xFF)|(\s)]/", $Categories[$i])) {
                        $Resp = $this->Connection->query("INSERT INTO `dictionary`(`Key`,`Value`,`Function`) VALUES ('" . EncodeAES('Cat' . $i) . "','" . EncodeAES(trim(mb_strtolower($Categories[$i]))) . "','" . FUNCTION_CATEGORY . "')");
                        if ($Resp !== TRUE) {
                            $this->Error(501);
                        }
                        $Resp = $this->Connection->query("ALTER TABLE `participants` ADD COLUMN `Cat" . $i . "` INT NOT NULL DEFAULT '0'");
                        if ($Resp !== TRUE) {
                            $this->Error(501);
                        }
                        $Resp = $this->Connection->query("ALTER TABLE `employees` ADD COLUMN `Cat" . $i . "` INT NOT NULL DEFAULT '1'");
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

    public function AddParticipants()
    {
        $uploadfile = PATH_FILES . basename($_FILES['uploadfile']['name']);
    }

    public function AddParticipant($Name, $Surname, $MiddleName, $Sex, $Team)
    {
        $this->CheckInputData($Name, $Surname, $MiddleName, $Sex, $Team);
        $Name = EncodeAES(mb_strtolower($Name));
        $Surname = EncodeAES(mb_strtolower($Surname));
        $MiddleName = EncodeAES(mb_strtolower($MiddleName));
        $Sex = EncodeAES(mb_strtolower($Sex));
        $Team = EncodeAES(mb_strtolower($Team));
        $this->AddParticipant_Main();
        $this->Select($this->User_Organization);
        $this->AddParticipant_Organization($Name, $Surname, $MiddleName, $Sex, $Team);
        $this->AddParticipant_Excel($Name, $Surname, $MiddleName, $Team);
        exit(json_encode(["status" => "OK", "code" => 200, "login" => DecodeAES($this->User_Login), "password" => $this->User_Password_Decoded]));
    }

    public function EditParticipantData($Login, $Name, $Surname, $MiddleName, $Sex, $Team)
    {
        $this->CheckInputData($Name, $Surname, $MiddleName, $Sex, $Team);
        $Login = EncodeAES($Login);
        $Name = EncodeAES(mb_strtolower($Name));
        $Surname = EncodeAES(mb_strtolower($Surname));
        $MiddleName = EncodeAES(mb_strtolower($MiddleName));
        $Sex = EncodeAES(mb_strtolower($Sex));
        $Team = EncodeAES(mb_strtolower($Team));
        $this->EditParticipantData_Organization($Login, $Name, $Surname, $MiddleName, $Sex, $Team);
        exit(json_encode(["status" => "OK", "code" => 200]));
    }

    public function EditEmployeeData($Login, $Name, $Surname, $MiddleName, $Sex, $Team, $Post)
    {
        $this->CheckInputData($Name, $Surname, $MiddleName, $Sex, $Team, $Post);
        $Login = EncodeAES($Login);
        $Name = EncodeAES(mb_strtolower($Name));
        $Surname = EncodeAES(mb_strtolower($Surname));
        $MiddleName = EncodeAES(mb_strtolower($MiddleName));
        $Sex = EncodeAES(mb_strtolower($Sex));
        $Team = EncodeAES(mb_strtolower($Team));
        $Post = EncodeAES(mb_strtolower($Post));
        $this->EditEmployeeData_Organization($Login, $Name, $Surname, $MiddleName, $Sex, $Team, $Post);
        exit(json_encode(["status" => "OK", "code" => 200]));
    }

    public function AddEmployee($Name, $Surname, $MiddleName, $Sex, $Team, $Post)
    {
        $this->CheckInputData($Name, $Surname, $MiddleName, $Sex, $Team, $Post);
        $Name = EncodeAES(mb_strtolower($Name));
        $Surname = EncodeAES(mb_strtolower($Surname));
        $MiddleName = EncodeAES(mb_strtolower($MiddleName));
        $Sex = EncodeAES(mb_strtolower($Sex));
        $Team = EncodeAES(mb_strtolower($Team));
        $Post = EncodeAES(mb_strtolower($Post));
        $this->AddEmployee_Main();
        $this->Select($this->User_Organization);
        $this->AddEmployee_Organization($Name, $Surname, $MiddleName, $Sex, $Team, $Post);
        $this->AddEmployee_Excel($Name, $Surname, $MiddleName, $Team);
        exit(json_encode(["status" => "OK", "code" => 200, "login" => DecodeAES($this->User_Login), "password" => $this->User_Password_Decoded]));
    }

    public function ChangeAllowCategory($UserID, $State, $CategoryID)
    {
        $Result = $this->Connection->query("UPDATE `employees` SET `" . $this->Connection->real_escape_string($CategoryID) . "`='" .
            $this->Connection->real_escape_string($State) . "' WHERE `Login`='" . EncodeAES($UserID) . "'");
        if ($Result === FALSE) {
            exit(json_encode(["status" => "ERROR", "code" => 501]));
        } else {
            exit(json_encode(["status" => "OK", "code" => 200]));
        }
    }

    public function DeleteParticipant($UserID)
    {
        $UserID = EncodeAES($UserID);
        $Resp = $this->Connection->query("DELETE FROM `participants` WHERE `Login`='$UserID'");
        if ($Resp === FALSE) {
            exit(json_encode(["status" => "ERROR", "code" => 501]));
        }
        $Resp = $this->Connection->query("DELETE FROM `users` WHERE `Login`='$UserID'");
        if ($Resp === FALSE) {
            exit(json_encode(["status" => "ERROR", "code" => 501]));
        }
        $this->Select("camp");
        $Resp = $this->Connection->query("DELETE FROM `users` WHERE `Login`='$UserID'");
        if ($Resp === FALSE) {
            exit(json_encode(["status" => "ERROR", "code" => 501]));
        }
        $Resp = $this->Connection->query("DELETE FROM `sessions` WHERE `Login`='$UserID'");
        if ($Resp === FALSE) {
            exit(json_encode(["status" => "ERROR", "code" => 501]));
        }
        exit(json_encode(["status" => "OK", "code" => 200]));
    }

    public function DeleteEmployee($UserID)
    {
        $UserID = EncodeAES($UserID);
        $Resp = $this->Connection->query("DELETE FROM `employees` WHERE `Login`='$UserID'");
        if ($Resp === FALSE) {
            exit(json_encode(["status" => "ERROR", "code" => 501]));
        }
        $Resp = $this->Connection->query("DELETE FROM `users` WHERE `Login`='$UserID'");
        if ($Resp === FALSE) {
            exit(json_encode(["status" => "ERROR", "code" => 501]));
        }
        $this->Select("camp");
        $Resp = $this->Connection->query("DELETE FROM `users` WHERE `Login`='$UserID'");
        if ($Resp === FALSE) {
            exit(json_encode(["status" => "ERROR", "code" => 501]));
        }
        $Resp = $this->Connection->query("DELETE FROM `sessions` WHERE `Login`='$UserID'");
        if ($Resp === FALSE) {
            exit(json_encode(["status" => "ERROR", "code" => 501]));
        }
        exit(json_encode(["status" => "OK", "code" => 200]));
    }

    public function EditMark($UserID, $CategoryID, $Reason, $Change)
    {
        $this->CheckReason($Reason);
        $this->CheckMarkChange($Reason);
        $this->Request_Login = EncodeAES($UserID);
        $this->CheckUsersOrganization();
        $TmpReturn = $this->Return;
        $this->Return = TRUE;
        $Functions = $this->GetFunctionsValues();
        $Abs = $Functions["abs"]["Value"];
        $TeamLeader = $Functions["team_leader"]["Value"];
        $RequestUserData = $this->GetUserData();
        $CurrentMark = $this->GetUserMark($CategoryID);
        $this->Request_Login = $this->User_Login;
        $UserData = $this->GetUserData();
        if ($TeamLeader == 0 and $RequestUserData["team"] == $UserData["team"]) {
            exit(json_encode(["status" => "ERROR", "code" => 606]));
        }
        $this->SetMark($UserID, $CategoryID, $Reason, $Change, $CurrentMark, $Abs);
        exit(json_encode(["status" => "OK", "code" => 200]));
    }

    private function SetMark($UserID, $CategoryID, $Reason, $Change, $CurrentMark, $Abs)
    {
        if ($Abs == 1) {
            $CurrentMark = $CurrentMark + $Change;
            $Result = $this->Connection->query("UPDATE `participants` SET `" . $this->Connection->real_escape_string($CategoryID) . "`='$CurrentMark' WHERE `Login`='" . EncodeAES($UserID) . "'");
        } else {
            $CurrentMark = $CurrentMark + $Change;
            if ($CurrentMark < 0) {
                $CurrentMark = 0;
            }
            $Result = $this->Connection->query("UPDATE `participants` SET `" . $this->Connection->real_escape_string($CategoryID) . "`='$CurrentMark' WHERE `Login`='" . EncodeAES($UserID) . "'");
        }
        if ($Result === FALSE) {
            exit(json_encode(["status" => "ERROR", "code" => 501]));
        }
    }

    public function ChangeAdditionalSettings($SettingName, $Value)
    {
        if($Value != '0' && $Value != '1'){
            exit(json_encode(["status"=>"ERROR", "code"=>600]));
        }
        $SettingName = EncodeAES($SettingName);
        $Value = EncodeAES($Value);
        $Result = $this->Connection->query("UPDATE `dictionary` SET `Value`='$Value' WHERE `Function`='$SettingName'");
        if($Result === FALSE){
            exit(json_encode(["status"=>"ERROR", "code"=>501]));
        } else {
            exit(json_encode(["status"=>"ERROR", "code"=>200]));
        }
    }

    private function CheckMarkChange($Change)
    {
        if (!preg_match("/[^(\d)|(\-)|(\+)]/", $Change)) {
            return TRUE;
        } else {
            exit(json_encode(["status" => "ERROR", "code" => 600]));
        }
    }

    private function CheckReason($Reason)
    {
        if (!preg_match("/[^(\w)|(\x7F-\xFF)|(\s)|(\-)|(\+)]/", $Reason)) {
            return TRUE;
        } else {
            exit(json_encode(["status" => "ERROR", "code" => 600]));
        }
    }

    private function AddParticipant_Excel($Name, $Surname, $Middlename, $Team)
    {
        $Name = DecodeAES($Name);
        $Surname = DecodeAES($Surname);
        $Middlename = DecodeAES($Middlename);
        $Team = DecodeAES($Team);
        try {
            $File = PHPExcel_IOFactory::createReader('Excel2007');
            $File = $File->load("../media/basedata/" . $this->User_Organization . "_participants.xlsx");
            $File->setActiveSheetIndex(0);
            $Sheet = $File->getActiveSheet();
            $Index = $Sheet->getHighestRow() + 1;
            $Sheet->setCellValueByColumnAndRow(0, $Index, $Name);
            $Sheet->setCellValueByColumnAndRow(1, $Index, $Surname);
            $Sheet->setCellValueByColumnAndRow(2, $Index, $Middlename);
            $Sheet->setCellValueByColumnAndRow(3, $Index, $Team);
            $Sheet->setCellValueByColumnAndRow(4, $Index, DecodeAES($this->User_Login));
            $Sheet->setCellValueByColumnAndRow(5, $Index, $this->User_Password_Decoded);
            $ExcelWriter = PHPExcel_IOFactory::createWriter($File, 'Excel2007');
            $ExcelWriter->save("../media/basedata/" . $this->User_Organization . "_participants.xlsx");
        } catch (Exception $e) {
            exit(json_encode(["status" => "ERROR", "code" => 506]));
        }
    }

    private function AddEmployee_Excel($Name, $Surname, $Middlename, $Team)
    {
        $Name = DecodeAES($Name);
        $Surname = DecodeAES($Surname);
        $Middlename = DecodeAES($Middlename);
        $Team = DecodeAES($Team);
        try {
            $File = PHPExcel_IOFactory::createReader('Excel2007');
            $File = $File->load("../media/basedata/" . $this->User_Organization . "_employees.xlsx");
            $File->setActiveSheetIndex(0);
            $Sheet = $File->getActiveSheet();
            $Index = $Sheet->getHighestRow() + 1;
            $Sheet->setCellValueByColumnAndRow(0, $Index, $Name);
            $Sheet->setCellValueByColumnAndRow(1, $Index, $Surname);
            $Sheet->setCellValueByColumnAndRow(2, $Index, $Middlename);
            $Sheet->setCellValueByColumnAndRow(3, $Index, $Team);
            $Sheet->setCellValueByColumnAndRow(4, $Index, DecodeAES($this->User_Login));
            $Sheet->setCellValueByColumnAndRow(5, $Index, $this->User_Password_Decoded);
            $ExcelWriter = PHPExcel_IOFactory::createWriter($File, 'Excel2007');
            $ExcelWriter->save("../media/basedata/" . $this->User_Organization . "_employees.xlsx");
        } catch (Exception $e) {
            exit(json_encode(["status" => "ERROR", "code" => 506]));
        }
    }

    private function CheckInputData($Name, $Surname, $Middlename, $Sex, $Team, $Post = "Test")
    {
        if (!preg_match("/[^(\w)|(\x7F-\xFF)|(\s)]/", $Name . $Surname . $Middlename . $Sex . $Team . $Post)) {
            $this->CheckParticipantData_Sex($Sex);
        } else {
            exit(json_encode(["status" => "ERROR", "code" => 600]));
        }
    }

    private function CheckParticipantData_Sex($Sex)
    {
        switch (mb_strtolower($Sex)) {
            case "мужской":
                return TRUE;
            case "женский":
                return TRUE;
            default:
                exit(json_encode(["status" => "ERROR", "code" => 600]));
        }
    }

    private function AddParticipant_Organization($Name, $Surname, $MiddleName, $Sex, $Team)
    {
        $Resp = $this->Connection->query("INSERT INTO `users`(`Login`, `Name`, `Surname`, `Middlename`, `Sex`, `Team`, `Avatar`, `Accesslevel`)
          VALUES ('$this->User_Login', '$Name', '$Surname', 
          '$MiddleName', '$Sex', '$Team', '" . EncodeAES("media/images/avatar_default.jpg") . "', '" . EncodeAES("participant") . "')");
        if (!$Resp) {
            exit(json_encode(["status" => "ERROR", "code" => 501]));
        }
        $Resp = $this->Connection->query("INSERT INTO `participants`(`Login`) VALUES ('$this->User_Login')");
        if (!$Resp) {
            exit(json_encode(["status" => "ERROR", "code" => 501]));
        }
    }

    private function EditParticipantData_Organization($Login, $Name, $Surname, $MiddleName, $Sex, $Team)
    {
        $Resp = $this->Connection->query("UPDATE `users` SET `Name`='$Name', `Surname`='$Surname', `Middlename`='$MiddleName', `Sex`='$Sex'
          , `Team` = '$Team' WHERE `Login`='$Login'");
        if (!$Resp) {
            exit(json_encode(["status" => "ERROR", "code" => 501]));
        }
    }

    private function EditEmployeeData_Organization($Login, $Name, $Surname, $MiddleName, $Sex, $Team, $Post)
    {
        $Resp = $this->Connection->query("UPDATE `users` SET `Name`='$Name', `Surname`='$Surname', `Middlename`='$MiddleName', `Sex`='$Sex'
          , `Team` = '$Team' WHERE `Login`='$Login'");
        if (!$Resp) {
            exit(json_encode(["status" => "ERROR", "code" => 501]));
        }
        $Resp = $this->Connection->query("UPDATE `employees` SET `Post`='$Post' WHERE `Login`='$Login'");
        if (!$Resp) {
            exit(json_encode(["status" => "ERROR", "code" => 501]));
        }
    }

    private function AddParticipant_Main()
    {
        $this->Select("camp");
        $this->GeneratePassword();
        $CurrentID = $this->Connection->query("SELECT MAX(`ID`) FROM `users`");
        $CurrentID = mysqli_fetch_array($CurrentID)[0] + 1;
        if ($CurrentID) {
            $this->User_Login = EncodeAES("participant_" . $CurrentID);
            $Resp = $this->Connection->query("INSERT INTO `users`(`Login`,`Password`,`Organization`) VALUES('" . $this->User_Login . "',
          '" . $this->User_Password . "', '" . EncodeAES($this->User_Organization) . "')");
            if (!$Resp) {
                exit(json_encode(["status" => "ERROR", "code" => 501]));
            }
        } else {
            exit(json_encode(["status" => "ERROR", "code" => 501]));
        }
    }

    private function AddEmployee_Main()
    {
        $this->Select("camp");
        $this->GeneratePassword();
        $CurrentID = $this->Connection->query("SELECT MAX(`ID`) FROM `users`");
        $CurrentID = mysqli_fetch_array($CurrentID)[0] + 1;
        if ($CurrentID) {
            $this->User_Login = EncodeAES("employee_" . $CurrentID);
            $Resp = $this->Connection->query("INSERT INTO `users`(`Login`,`Password`,`Organization`) VALUES('" . $this->User_Login . "',
          '" . $this->User_Password . "', '" . EncodeAES($this->User_Organization) . "')");
            if (!$Resp) {
                exit(json_encode(["status" => "ERROR", "code" => 501]));
            }
        } else {
            exit(json_encode(["status" => "ERROR", "code" => 501]));
        }
    }

    private function AddEmployee_Organization($Name, $Surname, $MiddleName, $Sex, $Team, $Post)
    {
        $Resp = $this->Connection->query("INSERT INTO `users`(`Login`, `Name`, `Surname`, `Middlename`, `Sex`, `Team`, `Avatar`, `Accesslevel`)
          VALUES ('$this->User_Login', '$Name', '$Surname', 
          '$MiddleName', '$Sex', '$Team', '" . EncodeAES("media/images/avatar_default.jpg") . "', '" . EncodeAES("employee") . "')");
        if (!$Resp) {
            exit(json_encode(["status" => "ERROR", "code" => 501]));
        }
        $Resp = $this->Connection->query("INSERT INTO `employees`(`Login`,`Post`) VALUES ('$this->User_Login', '$Post')");
        if (!$Resp) {
            exit(json_encode(["status" => "ERROR", "code" => 501]));
        }
    }

    private function GeneratePassword()
    {
        $this->User_Password_Decoded = random_int(1000000, 9999999);
        $this->User_Password = password_hash($this->User_Password_Decoded, PASSWORD_BCRYPT);
        if ($this->User_Password) {
            return TRUE;
        }
        exit(json_encode(["code" => 505, "status" => "ERROR"]));
    }

}