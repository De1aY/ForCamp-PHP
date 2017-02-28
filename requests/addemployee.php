<?php

require_once "../scripts/php/orgset.php";

$Token = filter_input(INPUT_POST, "token");
$Name = filter_input(INPUT_POST, "name");
$Surname = filter_input(INPUT_POST, "surname");
$MiddleName = filter_input(INPUT_POST, "middlename");
$Sex = filter_input(INPUT_POST, "sex");
$Team = filter_input(INPUT_POST, "team");
$Post = filter_input(INPUT_POST, "post");
$Request = new Orgset($Token);
$Request->AddEmployee($Name, $Surname, $MiddleName, $Sex, $Team, $Post);