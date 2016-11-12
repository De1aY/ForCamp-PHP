<?php
    require_once 'database.php';

    $DB = db_connect();
    $ID = $_GET['id'];
    $Result = $DB->query("SELECT `Name`, `Surname`, `ThirdName`, `Sport`, `Art`, `Study`, `Discipline`, `Squad` FROM `children`");
?>