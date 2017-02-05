<?php

require_once "userdata.php";

class Orgset extends UserData
{

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
            if($UserData["accesslevel"] !== "admin"){
                $this->Error(604);
            }
        } else {
            $this->Error(600);
        }
    }

    public function ChangeOrganizationName($OrgName)
    {
        $OrgName = strip_tags($OrgName);
        $OrgName = strtolower($OrgName);
        $OrgName = EncodeAES($OrgName);
        $Check = $this->Connection->query("UPDATE `dictionary` SET `Value`='" . $OrgName . "' WHERE `Function`='" . FUNCTION_ORGANIZATION . "'");
        if (!$Check) {
            return $this->Error(501);
        } else {
            return EchoJSON(["code" => 200, "status" => "OK"]);
        }
    }

    public function ChangeParticipantName($PartName)
    {
        $PartName = strip_tags($PartName);
        $PartName = strtolower($PartName);
        $PartName = EncodeAES($PartName);
        $Check = $this->Connection->query("UPDATE `dictionary` SET `Value`='" . $PartName . "' WHERE `Function`='" . FUNCTION_PARTICIPANT . "'");
        if (!$Check) {
            return $this->Error(501);
        } else {
            return EchoJSON(["code" => 200, "status" => "OK"]);
        }
    }

    public function ChangeTeamName($TeamName)
    {
        $TeamName = strip_tags($TeamName);
        $TeamName = strtolower($TeamName);
        $TeamName = EncodeAES($TeamName);
        $Check = $this->Connection->query("UPDATE `dictionary` SET `Value`='" . $TeamName . "' WHERE `Function`='" . FUNCTION_TEAM . "'");
        if (!$Check) {
            return $this->Error(501);
        } else {
            return EchoJSON(["code" => 200, "status" => "OK"]);
        }
    }

    public function ChangePeriodName($PerName)
    {
        $PerName = strip_tags($PerName);
        $PerName = strtolower($PerName);
        $PerName = EncodeAES($PerName);
        $Check = $this->Connection->query("UPDATE `dictionary` SET `Value`='" . $PerName . "' WHERE `Function`='" . FUNCTION_PERIOD . "'");
        if (!$Check) {
            return $this->Error(501);
        } else {
            return EchoJSON(["code" => 200, "status" => "OK"]);
        }
    }
}