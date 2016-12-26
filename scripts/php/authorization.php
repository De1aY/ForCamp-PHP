<?php
    require_once 'lib.php';

    $Login = $_POST['login'];
    $Password = $_POST['password'];
    $Token = $_POST['token'];
    $Platform = $_POST['platform'];
    $Platform = strtoupper(trim($Platform));
    switch($Platform){
        case "WEB":
            $Authorization = new Authorization_Web($Login, $Password, $Token);
            if($Authorization->Status == 200){
                $Authorization->Authorize();
            }
            break;
        case "MOBILE":
            $Authorization = new Authorization_Mobile($Login, $Password, $Token);
            if($Authorization->Status == 200){
                $Authorization->Authorize();
            }
        default:
            $Authorization = new Authorization_Web();
    }  
?>