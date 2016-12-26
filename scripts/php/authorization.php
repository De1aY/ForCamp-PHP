<?php
    require_once 'lib.php';

    $Login = $_POST['login'];
    $Password = $_POST['password'];
    $Token = $_POST['token'];
    $Authorization = new Authorization_Mobile($Login, $Password, $Token);
    if($Authorization->Status == 200){
    	$Authorization->Authorize();
    }
?>