<?php
    require_once 'lib.php';

    session_start();
    $Authorization = new Authorization();
    $Authorization->Init($_POST['login'], $_POST['password']);
    $Validation = $Authorization->UserCheck();
    echo $Validation;
    if($Validation){
        $Token = session_id();
        $Authorization->Success($Token);
    }
    else{
        $Authorization->Error($Validation);
    }
?>