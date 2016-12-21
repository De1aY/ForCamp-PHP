<?php
    require_once 'lib.php';

    $Login = $_POST['login'];
    $Password = $_POST['password'];
    $Token = $_POST['token'];
    $Platform = $_POST['platform'];
    $Platform = strtoupper($Platform);
    $Authorization = new Authorization($Login, $Password, $Token, $Platform);
    $Authorization->UserCheckValidation();
    $Authorization->Close();
?>