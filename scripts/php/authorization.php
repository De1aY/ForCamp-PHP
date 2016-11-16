<?php
    require_once 'lib.php';

    session_start();
    $Authorization = new Authorization();
    $Login = $_POST['login'];
    $Password = $_POST['password'];
    $Init = $Authorization->Init($Login, $Password);
    if($Init != 401 or $Init != 500){
        $Validation = $Authorization->UserCheckValidation();
        if($Validation){
            $Token = session_id();
            $Authorization->Success($Token);
        }
        else{
            $Authorization->Error($Validation);
        }
    }
    else{
        $Authorization->Error($Init);
    }
?>