<?php
    require_once 'database.php';
    
    session_start();
    $DB = db_connect();
    $Data=$_POST;
    $Login =$Data['login'];
    $Password =md5($Data['password']);
    if(mysqli_fetch_assoc($DB->query("SELECT COUNT('Name') FROM `tutor` WHERE `Login`='".$DB->real_escape_string($Login)."' AND `Password`='".$DB->real_escape_string($Password)."'"))["COUNT('Name')"] == 1){
        $Token = session_id();
        $DB->query("UPDATE `tutor` SET `Token`='$Token' WHERE `Login`='".$DB->real_escape_string($Login)."'");
        $Output = array("Token" => $Token);
        echo json_encode($Output);
    }
    else{
        $Output = array("ERROR" => 401);  //401 - Login or Password is wrong
        echo json_encode($Output);
    }
    $DB->close();
?>