<?php
	require_once "scripts/php/lib.php";

	session_start();
    if(isset($_SESSION['Token'])){
        if(CheckToken($_SESSION['Token'], "web") == 200){
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
	<title>ForCamp | Authorization</title>
	<link rel="stylesheet" href="css/authorization.css">
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
	<div class="container col-lg-2 col-lg-offset-5 col-xs-5 col-xs-offset-4">
		<div class="input-group col-lg-12">
		    <input id="login" type="text" class="form-control" id="inputEmail" placeholder="Введите логин" aria-describedby="sizing-addon1">
		</div>
		<div class="input-group col-lg-12">
			<input id="password" type="password" class="form-control" id="inputPassword" placeholder="Введите пароль" aria-describedby="sizing-addon1">
		</div>
		<input id="submit" type="submit" class="form-control" placeholder="Username" aria-describedby="sizing-addon1" value="Войти">
	<!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <!-- Notie.js -->
    <script src="scripts/js/notie.js"></script>
    <!-- Other scrits -->
    <script src="scripts/js/authorization.js"></script>
</body>
</html>