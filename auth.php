<?php
$sid = filter_input(INPUT_COOKIE, 'sid');
if (isset($sid)) {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ForCamp | Авторизация</title>
    <link rel="stylesheet" href="scss/authorization.css">
    <!-- MDL -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-red.min.css" />
    <!-- Notie js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/notie/3.9.5/notie.min.css">
    <!-- MaterialPreloader -->
    <link rel="stylesheet" type="text/css" href="css/materialPreloader.min.css">
    <!-- WaveEffect -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/node-waves/0.7.5/waves.min.css">
    <!--[if IE]>
    <script src="//cdnjs.cloudflare.com/ajax/libs/es5-shim/4.2.0/es5-shim.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/classlist/2014.01.31/classList.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/selectivizr/1.0.2/selectivizr-min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container mdl-grid">
    <div class="login_form mdl-card mdl-cell mdl-shadow--6dp mdl-cell--middle mdl-cell--4-col-phone mdl-cell--4-col-tablet mdl-cell--2-offset-tablet mdl-cell--4-col-desktop mdl-cell--4-offset-desktop">
        <div class="mdl-card__actions">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" id="input_login">
                <input class="mdl-textfield__input" type="text" id="login">
                <label class="mdl-textfield__label" for="login">Логин</label>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" id="input_password">
                <input class="mdl-textfield__input" type="password" id="password">
                <label class="mdl-textfield__label" for="password">Пароль</label>
            </div>
            <button class="mdl-button mdl-js-button mdl-button--raised wave-effect mdl-button--primary" id="submit">войти</button>
        </div>
        <div class="mdl-card__actions"></div>
    </div>
</div>
<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<!-- MDL -->
<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
<!-- Notie.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/notie/3.9.5/notie.min.js"></script>
<!-- MaterialPreloader -->
<script type="text/javascript" src="scripts/js/materialPreloader.min.js"></script>
<!-- WaveEffect -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/node-waves/0.7.5/waves.min.js"></script>
<!-- Other scripts -->
<script src="scripts/js/auth.js"></script>
<script type="text/javascript" src="scripts/js/waveeffect.js"></script>
</body>
</html>