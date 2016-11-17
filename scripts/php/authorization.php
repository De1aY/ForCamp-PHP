<?php
    require_once 'lib.php';

    $Login = $_POST['login'];
    $Password = $_POST['password'];
    $Authorization = new Authorization($Login, $Password, NULL);
    if($Authorization){
        $Authorization->UserCheckValidation();
        $Authorization->Close();
    }
    else{
        $Authorization->Close();
    }
?>