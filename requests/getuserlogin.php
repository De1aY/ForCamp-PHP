<?php
	require_once "../scripts/php/lib.php";

	if(isset($_POST['token']) and isset($_POST['platform'])){
		$Platform = strtoupper(trim($_POST['platform']));
		$Token = $_POST['token'];
		$Req = new Requests();
		$Req->GetUserLogin($Token, $Platform);
	}
	else{
		$Data = new Data_User(NULL, NULL, NULL);
	}
?>