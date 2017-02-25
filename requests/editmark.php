<?php
require_once "../scripts/php/orgset.php";

$Token = filter_input(INPUT_POST, "token");
$UserID = filter_input(INPUT_POST, "userID");
$Change = filter_input(INPUT_POST, "change");
$CategoryID = filter_input(INPUT_POST, "categoryID");
$Reason = filter_input(INPUT_POST, "reason");
$Request = new Orgset($Token, FALSE, TRUE);
$Request->EditMark($UserID, $CategoryID, $Reason, $Change);
