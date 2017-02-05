<?php

require_once "../scripts/php/orgset.php";

$Token = filter_input(INPUT_POST, "token");
$PerName = filter_input(INPUT_POST, "pername");
$Request = new Orgset($Token);
$Request->ChangePeriodName($PerName);
$Request->Close();