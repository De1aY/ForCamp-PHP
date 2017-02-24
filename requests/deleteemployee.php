<?php

require_once "../scripts/php/orgset.php";

$Token = filter_input(INPUT_POST, "token");
$UserID = filter_input(INPUT_POST, "userID");
$Request = new Orgset($Token);
$Request->DeleteEmployee($UserID);