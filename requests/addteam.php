<?php

require_once "../scripts/php/orgset.php";

$Token = filter_input(INPUT_POST, "token");
$TeamName = filter_input(INPUT_POST, "teamName");
$Request = new Orgset($Token);
$Request->AddTeam($TeamName);