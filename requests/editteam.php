<?php

require_once "../scripts/php/orgset.php";

$Token = filter_input(INPUT_POST, "token");
$TeamName_New = filter_input(INPUT_POST, "teamNameNew");
$TeamName_Old = filter_input(INPUT_POST, "teamNameOld");
$Request = new Orgset($Token);
$Request->EditTeam($TeamName_Old, $TeamName_New);