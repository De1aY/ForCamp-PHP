<?php
	require_once "../scripts/php/lib.php";

	function SwitchPlatform($Platform, $Login, $Token){
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

	if(isset($_POST['token']) and isset($_POST['platform']) and isset($_POST['login'])){
		$Platform = strtoupper(trim($_POST['platform']));
		$Login = trim($_POST['login']);
		$Token = $_POST['token'];
		if(CheckToken($Token, $Platform) == 200){
			SwitchPlatform($Platform, $Login, $Token);
		}
		else{
			return EchoJSON(array("status" => "ERROR", "token" => "", "code" => 602));
		}
	}
	else{
		$Data = new Data_User(NULL, NULL, NULL);
	}
?>