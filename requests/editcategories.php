<?php

require_once "../scripts/php/orgset.php";

$Token = filter_input(INPUT_POST, "token");
$Categories = filter_input(INPUT_POST, "categories");
try {
    $Categories = json_decode($Categories);
} catch (Exception $e) {
    exit(json_encode(["code" => 600, "status" => "ERROR"]));
}
$Req = new Orgset($Token);
$Req->EditCategories($Categories);
$Req->Close();