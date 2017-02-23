<?php

require_once "scripts/php/userdata.php";

$sid = filter_input(INPUT_COOKIE, 'sid');
if (!isset($sid)) {
    header("Location: auth.php");
}
$Data = new UserData($sid, NULL, TRUE);
$Login = $Data->GetUserLogin();
if(!$Login){
    header("Location: exit.php");
}
$UserData = $Data->GetUserData();
?>
<?php if (isset($sid) && isset($Login)): ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ForCamp | Главная</title>
    <link rel="stylesheet" href="scss/index.css">
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
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
    <header class="mdl-layout__header">
        <div class="mdl-layout__header-row">
            <!-- Title -->
            <span class="mdl-layout-title"><?php echo $UserData["organization"]?></span>
        </div>
    </header>
    <div class="mdl-layout__drawer">
        <span class="mdl-layout-title">главная</span>
        <nav class="mdl-navigation">
            <a class="mdl-navigation__link wave-effect" href="profile.php?login=<?php echo $Login ?>">профиль</a>
            <?php if ($UserData['accesslevel'] === "admin"): ?>
                <a class="mdl-navigation__link wave-effect" href="orgset.php">управление</a>
            <?php endif ?>
            <a class="mdl-navigation__link wave-effect" href="">общая статистика</a>
            <a class="mdl-navigation__link wave-effect" href="">класс</a>
            <a class="mdl-navigation__link wave-effect" href="">достижения</a>
            <a class="mdl-navigation__link wave-effect" href="exit.php">выйти</a>
        </nav>
    </div>
    <main class="mdl-layout__content">
        <div class="page-content"><!-- Your content goes here --></div>
    </main>
</div>
<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<!-- MDL -->
<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
<!-- Notie.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/notie/3.9.5/notie.min.js"></script>
<!-- WaveEffect -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/node-waves/0.7.5/waves.min.js"></script>
<!-- MaterialPreloader -->
<script type="text/javascript" src="scripts/js/materialPreloader.min.js"></script>
<!-- Other scripts -->
<script src="scripts/js/index.js"></script>
<script type="text/javascript" src="scripts/js/waveeffect.js"></script>
</body>
</html>
<?php endif ?>