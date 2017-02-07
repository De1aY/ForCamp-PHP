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
                        $Resp = $this->Connection->query("INSERT INTO `dictionary`(`Key`,`Value`,`Function`) VALUES ('" . EncodeAES('Cat' . $i) . "','" . EncodeAES(strtolower($Categories[$i])) . "','" . FUNCTION_CATEGORY . "')");
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
}