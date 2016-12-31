<?php
	require_once "../scripts/php/lib.php";

	if(isset($_POST['token']) and isset($_POST['platform']) and isset($_POST['login'])){
		$Platform = strtoupper(trim($_POST['platform']));
		$Login = trim($_POST['login']);
		$Token = $_POST['token'];
		$Req = new Requests();
		$Req->GetTeamValue($Token, $Platform, $Login);
	}
	else{
		$Data = new Data_User(NULL, NULL, NULL);
	}
?>