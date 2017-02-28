<?php

require_once "scripts/php/lib.php";

$Encode = filter_input(INPUT_GET, "encode");
$Decode = filter_input(INPUT_GET, "decode");
$JSON = [];

$JSON[$Encode] = EncodeAES($Encode);
$JSON[$Decode] = DecodeAES($Decode);

echo json_encode($JSON);

