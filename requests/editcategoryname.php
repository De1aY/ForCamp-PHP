<?php

require_once "../scripts/php/orgset.php";

$Token = filter_input(INPUT_POST, "token");
$CategoryID = filter_input(INPUT_POST, "categoryID");
$CategoryName = filter_input(INPUT_POST, "categoryName");
$Request = new Orgset($Token);
$Request->EditCategory($CategoryID, $CategoryName);