<?php

require_once "../scripts/php/orgset.php";

$Token = filter_input(INPUT_POST, "token");
$OrgName = filter_input(INPUT_POST, "orgname");
$Request = new Orgset($Token);
$Request->ChangeOrganizationName($OrgName);
$Request->Close();