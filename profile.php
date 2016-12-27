<?php
	require_once "scripts/php/lib.php";

    session_start();
    if(isset($_SESSION['Token'])){
        if(CheckToken($_SESSION['Token'], "web") != 200){
            session_unset();
            session_write_close();
            header("Location: authorization.php");
        }
        else{
        	$Token = $_SESSION['Token'];
        	echo "<i id='token'>$Token</i>";
        }
    }
    else{
        header("Location: authorization.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ForCamp | Профиль</title>
    <link rel="stylesheet" href="css/profile.css">
    <!-- MaterialPreloader -->
    <link rel="stylesheet" type="text/css" href="css/materialPreloader.min.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
     <!-- Notie.js -->
    <link rel="stylesheet" href="css/notie.css">
    <!-- WaveEffect -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/node-waves/0.7.5/waves.min.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <nav class="header navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" id="collapse-button" data-target="#collapse" aria-expanded="false">меню</button>
                <i id="profile" class="navbar-brand">профиль</i>
            </div>
            <div class="collapse navbar-collapse" id="collapse">
                <ul class="nav navbar-nav">
                    <li><a id="main" href="index.php">главная</a></li>
                    <li><a id="all" href="index.php?page=all">общая статистика</a></li>
                    <li><a id="group" href="index.php?page=group">класс</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a id="exit" href="exit.php">выйти</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="content col-xs-12 col-sm-12 col-md-12 col-lg-12">
    	<div class="UserName col-lg-12"></div>
    	<img src="media/images/innopolis_1.png" class="avatar col-lg-offset-2">
		<div class="UserPanel col-lg-12">
			<div class="Settings">отправить сообщение</div>
			<div class="Name col-lg-offset-2">undefenited</div>
			<div class="Achievements">достижения</div>
		</div>
		<div class="UserInf col-lg-12"></div>
    </div>
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <!-- WaveEffect -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/node-waves/0.7.5/waves.min.js"></script>
    <!-- MaterialPreloader -->
    <script type="text/javascript" src="scripts/js/materialPreloader.min.js"></script>
    <!-- Notie.js -->
    <script src="scripts/js/notie.js"></script>
    <!-- Other scripts -->
    <script type="text/javascript" src="scripts/js/profile.js"></script>
</body>
</html>