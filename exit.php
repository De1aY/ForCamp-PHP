<?php

require_once "scripts/php/userdata.php";

$sid = filter_input(INPUT_COOKIE, 'sid');
$Close = new UserData($sid);
$Close->CloseSession();
