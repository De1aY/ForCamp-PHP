<?php

require_once "../scripts/php/orgset.php";

$Token = filter_input(INPUT_POST, "token");
$PartName = filter_input(INPUT_POST, "partname");
$Request = new Orgset($Token);
$Request->ChangeParticipantName($PartName);
$Request->Close();