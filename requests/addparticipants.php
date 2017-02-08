<?php

require_once "../scripts/php/orgset.php";

$Token = filter_input(INPUT_POST, "token");

$Req = new Orgset($Token);