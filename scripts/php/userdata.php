<?php

require_once "authorization.php";

class UserData extends Authorization
{
    private $User_Organization = NULL;
    private $Request_Login = NULL;
    private $Owner = FALSE;

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
            }
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
            }
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
            $Data = $this->Connection->query("SELECT `name`,`surname`,`middlename`,`avatar`,`post`,`sex`,`accesslevel`,`team` FROM `users` WHERE `login`='" . $this->Connection->real_escape_string($this->Request_Login) . "'");
            if (!is_bool($Data)) {
                $Data = mysqli_fetch_assoc($Data);
                $Data = array_map("DecodeAES", $Data);
                $Data = array_merge($Data, ["organization" => $this->ReturnValueForViewByKey(EncodeAES($this->User_Organization)), "owner" => $this->Owner]);
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
        $Categories = $this->Connection->query("SELECT `Key`,`Value` FROM `dictionary` WHERE `Function`='" . $this->Connection->real_escape_string(FUNCTION_CATEGORY) . "'");
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
            $Data= array_merge($Data, [$Categories[$i] => $this->GetUserMark($Categories[$i])]);
        }
        if(is_array($Data)){
            return $Data;
        }
        else{
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

    private function GetUserMark($Category)
    {
        $Mark = $this->Connection->query("SELECT `".$Category."` FROM `participants` WHERE `Login`='".$this->Connection->real_escape_string($this->Request_Login)."'");
        if(!is_bool($Mark)){
            $Mark = mysqli_fetch_all($Mark);
            return $Mark[0];
        }
        else{
            $this->Error(501);
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

    /**
     * @param string $Key
     * @return string
     */
    private function ReturnValueForViewByKey($Key)
    {
        $Value = $this->Connection->query("SELECT `Value` FROM `dictionary` WHERE `Key`='" . $this->Connection->real_escape_string($Key) . "'");
        if (!is_bool($Value)) {
            $Value = mysqli_fetch_assoc($Value)["Value"];
            if (is_string($Value)) {
                return DecodeAES($Value);
            }
        }
    }

}