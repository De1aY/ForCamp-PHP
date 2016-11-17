<?php
    require_once 'lib.php';

    $Login = $_POST['login'];
    $Password = $_POST['password'];
    $Authorization = new Authorization($Login, $Password, NULL);
    $Authorization->UserCheckValidation();
    $Authorization->Close();
?>