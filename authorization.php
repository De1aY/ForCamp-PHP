<?php
	require_once "scripts/php/lib.php";

	session_start();
    if(isset($_SESSION['Token'])){
        $Req = new Requests();
        if($Req->CheckToken($_SESSION['Token'], "WEB") == 200){
            header("Location: Index.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ForCamp | Авторизация</title>
    <link rel="stylesheet" href="css/common.css">
	<link rel="stylesheet" href="css/authorization.css">
    <!-- Hover CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/hover.css/2.1.0/css/hover-min.css">
	<!-- MaterialPreloader -->
    <link rel="stylesheet" type="text/css" href="css/materialPreloader.min.css">
	<!-- WaveEffect -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/node-waves/0.7.5/waves.min.css">
	<!-- Notie.js -->
	<link rel="stylesheet" href="css/notie.css">
	<!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
	<div class="container col-lg-2 col-lg-offset-5 col-xs-8 col-xs-offset-2 col-sm-3 col-sm-offset-5 ">
		<div class="input-group">
		    <input id="login" type="text" class="form-control" id="inputLogin" placeholder="Введите логин" aria-describedby="sizing-addon1">
		</div>
		<div class="input-group">
			<input id="password" type="password" class="form-control" id="inputPassword" placeholder="Введите пароль" aria-describedby="sizing-addon1">
		</div>
		<input id="submit" type="submit" class="wave-effect form-control" aria-describedby="sizing-addon1" value="Войти">
	<!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <!-- Notie.js -->
    <script src="scripts/js/notie.js"></script>
    <!-- WaveEffect -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/node-waves/0.7.5/waves.min.js"></script>
    <!-- MaterialPreloader -->
    <script type="text/javascript" src="scripts/js/materialPreloader.min.js"></script>
    <!-- Other scrits -->
    <script type="text/javascript" src="scripts/js/waveeffect.js"></script>
    <script src="scripts/js/authorization.js"></script>
</body>
</html>