<?php
	require_once "../scripts/php/lib.php";

	if(isset($_POST['token']) and isset($_POST['platform'])){
		$Platform = strtoupper(trim($_POST['platform']));
		switch($Platform){
			case "WEB":
				$Data = new Data_Core($_POST['token'], $Platform);
				if($Data->Status == 200){
					$Data->GetUserData();
				}
				break;
			case "MOBILE":
				$Data = new Data_Core($_POST['token'], $Platform);
				if($Data->Status == 200){
					$Data->GetUserData();
				}
				break;
			default:
				$Data = new Data_Core(NULL, NULL);
				break;
		}
	}
	else{
		$Data = new Data_Core(NULL, NULL);
	}
?>