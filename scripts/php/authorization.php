<?php

require_once "database.php";

class Authorization extends DataBase
{
    private $Salt = "f59761522aaf0cf9";
    protected $User_Login = NULL;
    protected $User_Password = NULL;
    protected $User_Token = NULL;
    protected $Return = FALSE;

    /**
     * Authorization constructor.
     * @param string $Login
     * @param string $Password
     * @param string $Token
     * @param bool $Return
     * @return Authorization
     */
    function Authorization($Login = NULL, $Password = NULL, $Token = NULL, $Return = FALSE)
    {
        $this->Return = $Return;
        $this->Connect();
        if (isset($Login) && isset($Password)) {
            $this->User_Login = EncodeAES($Login);
            $this->User_Password = $Password;
        } elseif (isset($Token)) {
            $this->User_Token = $Token;
        } else {
            $this->Error(600);
        }
    }

    /**
     * @return bool|void
     */
    public function Authorize()
    {
        if (isset($this->User_Token)) {
            return $this->CheckToken();
        } else {
            return $this->CheckUserInf();
        }
    }

    private function CheckToken()
    {
        $Count = $this->Connection->query("SELECT COUNT('login') FROM `sessions` WHERE `token`='" . $this->Connection->real_escape_string($this->User_Token) . "'");
        if (!is_bool($Count)) {
            $Count = mysqli_fetch_assoc($Count)["COUNT('login')"];
            if ($Count > 0) {
                return $this->Success();
            } else {
                return $this->Error(602);
            }
        } else {
            return $this->Error(501);
        }
    }

    private function CheckUserInf()
    {
        $PasswordHash = $this->Connection->query("SELECT `password` FROM `users` WHERE `login`='" . $this->Connection->real_escape_string($this->User_Login) . "'");
        if (!is_bool($PasswordHash)) {
            $PasswordHash = mysqli_fetch_assoc($PasswordHash)["password"];
            if (password_verify($this->User_Password, $PasswordHash)) {
                return $this->SetToken();
            } else {
                $this->Error(601);
            }
        } else {
            return $this->Error(501);
        }
    }

    /**
     * @param $Token
     * @return bool
     */
    protected function CheckForMatches($Token)
    {
        $Count = $this->Connection->query("SELECT COUNT('login') FROM `sessions` WHERE `token`='" . $this->Connection->real_escape_string($Token) . "'");
        if (!is_bool($Count)) {
            $Count = mysqli_fetch_assoc($Count)["COUNT('login')"];
            if ($Count == 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return $this->Error(501);
        }
    }

    private function GenerateToken()
    {
        while (TRUE) {
            $Token = md5(md5(time() . $this->User_Login . $this->Salt) . md5(time() . $this->Salt) . $this->Salt);
            if ($this->CheckForMatches($Token)) {
                return $Token;
            } else {
                continue;
            }
        }
    }

    private function CheckSessions()
    {
        $Count = $this->Connection->query("SELECT COUNT('token') FROM `sessions` WHERE `login`='" . $this->Connection->real_escape_string($this->User_Login) . "'");
        if (!is_bool($Count)) {
            $Count = mysqli_fetch_assoc($Count)["COUNT('token')"];
            if ($Count > 4) {
                $Delete = $this->Connection->query("DELETE FROM `sessions` WHERE `login`='" . $this->Connection->real_escape_string($this->User_Login) . "' LIMIT 1");
                if ($Delete === TRUE) {
                    return TRUE;
                } else {
                    return $this->Error(501);
                }
            } else {
                return TRUE;
            }
        } else {
            return $this->Error(501);
        }
    }

    private function SetSession()
    {
        $Insert = $this->Connection->query("INSERT INTO `sessions` (`login`,`token`) VALUES ('$this->User_Login','$this->User_Token')");
        if ($Insert) {
            return TRUE;
        } else {
            return $this->Error(501);
        }
    }

    private function SetToken()
    {
        $this->CheckSessions();
        $this->User_Token = $this->GenerateToken();
        $this->SetSession();
        setcookie("sid", $this->User_Token, time() + 1209600, "/");
        return $this->Success();
    }

    protected function Success()
    {
        if ($this->Return === TRUE) {
            return TRUE;
        } else {
            $Dump = $this->Connection->query('show profiles');
            while($rd = mysqli_fetch_object($Dump))
            {
                echo $rd->Query_ID.' - '.round($rd->Duration,4) * 1000 .' ms - '.$rd->Query.'<br />';
            }
            $this->Close();
            exit(json_encode(["status" => "OK", "code" => 200, "token" => $this->User_Token]));
        }
    }

    /**
     * @param int $ErrorCode
     * @return bool
     */
    protected function Error($ErrorCode)
    {
        if ($this->Return === TRUE) {
            return FALSE;
        } else {
            $this->Close();
            exit(json_encode(["status" => "ERROR", "code" => $ErrorCode]));
        }
    }

}