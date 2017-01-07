<?php

require_once "../scripts/php/userdata.php";

$Token = filter_input(INPUT_POST, 'token');
$Login = filter_input(INPUT_POST, 'login');
$Key = filter_input(INPUT_POST, 'key');
$Request = new UserData($Token, $Login);
$Request->GetValueForViewByKey($Key);