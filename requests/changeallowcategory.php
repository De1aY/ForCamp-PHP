<?php

require_once "../scripts/php/orgset.php";

$Token = filter_input(INPUT_POST, "token");
$UserID = filter_input(INPUT_POST, "userID");
$State = filter_input(INPUT_POST, "state");
$CategoryID = filter_input(INPUT_POST, "categoryID");
$Request = new Orgset($Token);
$Request->ChangeAllowCategory($UserID, $State, $CategoryID);