<?php

require_once "../scripts/php/userdata.php";

$Token = filter_input(INPUT_POST, 'token');
$Login = filter_input(INPUT_POST, 'login');
$Request = new UserData($Token, $Login);
$Request->GetUserData();