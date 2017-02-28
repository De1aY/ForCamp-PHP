<?php

require_once "../scripts/php/authorization.php";

$Login = filter_input(INPUT_POST, 'login');
$Password = filter_input(INPUT_POST, 'password');
$Token = filter_input(INPUT_POST, 'token');
$Auth = new Authorization($Login, $Password, $Token);
$Auth->Authorize();