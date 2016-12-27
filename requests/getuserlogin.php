<?php
	require_once "../scripts/php/lib.php";

	function SwitchPlatform($Platform, $Token){
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

	if(isset($_POST['token']) and isset($_POST['platform'])){
		$Platform = strtoupper(trim($_POST['platform']));
		$Login = trim($_POST['login']);
		$Token = $_POST['token'];
		if(CheckToken($Token, $Platform) == 200){
			SwitchPlatform($Platform, $Token);
		}
		else{
			return EchoJSON(array("status" => "ERROR", "token" => "", "code" => 602));
		}
	}
	else{
		$Data = new Data_User(NULL, NULL, NULL);
	}
?>