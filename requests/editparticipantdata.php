<?php

require_once "../scripts/php/orgset.php";

$Token = filter_input(INPUT_POST, "token");
$Login = filter_input(INPUT_POST, "login");
$Name = filter_input(INPUT_POST, "name");
$Surname = filter_input(INPUT_POST, "surname");
$MiddleName = filter_input(INPUT_POST, "middlename");
$Sex = filter_input(INPUT_POST, "sex");
$Team = filter_input(INPUT_POST, "team");
$Request = new Orgset($Token);
$Request->EditParticipantData($Login, $Name, $Surname, $MiddleName, $Sex, $Team);