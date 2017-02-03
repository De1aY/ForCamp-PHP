<?php

require_once "scripts/php/lib.php";

$JSON = [];

$JSON["FUNCTION_STARTER"] = EncodeAES("starter");
$JSON["DECODE"] = DecodeAES("vKoiApU10depLCURuv+2tg==");

echo json_encode($JSON);

