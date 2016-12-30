<?php
	require_once "scripts/php/lib.php";

    session_start();
    if(isset($_SESSION['Token'])){
        	$Token = $_SESSION['Token'];
        	echo "<i id='token'>$Token</i>";
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
    <title>ForCamp | Личный кабинет</title>
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/account.css">
    <!-- Hover CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/hover.css/2.1.0/css/hover-min.css">
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
                <a href="" id="profile" class="wave-effect navbar-brand menu_button">профиль</a>
            </div>
            <div class="collapse navbar-collapse" id="collapse">
                <ul class="nav navbar-nav">
                    <li><a class="wave-effect menu_button" id="main" href="index.php">главная</a></li>
                    <li><a class="wave-effect menu_button" id="all" href="index.php?page=all">сообщения</a></li>
                    <li><a class="wave-effect menu_button active" id="group" href="index.php?page=group">настройки</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a class="wave-effect menu_button" id="exit" href="exit.php">выйти</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="content">
        <div class="margin-top"></div>
        <div class="user-inf">
            <img src="media/images/innopolis_1.png" class="avatar hvr-ripple-out">
            <div class="fullname">
                <div class="fullname_margin"></div>
                <div class="fullname_text">undefenited</div>
            </div>
            <div class="data">
                <div class="data_box" id="authorization_data">
                    <h2 class="data_box_header">
                        <div class="data_box_header_text">логин и пароль</div>
                        <div class="data_box_header_pencil fa fa-pencil"></div>
                    </h2>
                </div>
            </div>
            <div class="data">
                <div class="data_box" id="main_data">
                    <div class="data_box_header">
                        <div class="data_box_header_text"></div>
                        <div class="data_box_header_pencil fa fa-pencil"></div>
                    </div>
                </div>
            </div>
            <!-- Админская часть -->
            <?php

            ?>
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
    <script type="text/javascript" src="scripts/js/waveeffect.js"></script>
    <script type="text/javascript" src="scripts/js/account.js"></script>
</body>
</html>