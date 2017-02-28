<?php

require_once "../scripts/php/orgset.php";

$Token = filter_input(INPUT_POST, "token");
$SettingName = filter_input(INPUT_POST, "settingName");
$Value = filter_input(INPUT_POST, "value");
$Request = new Orgset($Token);
$Request->ChangeAdditionalSettings($SettingName, $Value);