<?php

require_once "../scripts/php/userdata.php";

$Token = filter_input(INPUT_COOKIE, "sid");

$Request = new UserData($Token, NULL, FALSE);
$Request->GetFunctionsValues();
$Request->Close();