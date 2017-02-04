<?php

require_once "scripts/php/userdata.php";

$sid = filter_input(INPUT_COOKIE, 'sid');
if (!isset($sid)) {
    header("Location: index.php");
}
$Request = new UserData($sid, NULL, TRUE);
$RequestData = $Request->GetUserData();
if ($RequestData['accesslevel'] != "admin") {
    header("Location: index.php");
}
$Login = $Request->GetUserLogin();
?>
<?php if (isset($sid) && $RequestData['accesslevel'] === "admin"): ?>
    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ForCamp | Панель управления</title>
        <link rel="stylesheet" href="scss/orgset.css">
        <!-- MDL -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-red.min.css"/>
        <!-- FontAwesome -->
        <link rel="stylesheet" href="css/font-awesome.min.css">
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
                <span class="mdl-layout-title"><?php echo $RequestData['organization'] ?></span>
            </div>
        </header>
        <div class="mdl-layout__drawer">
            <span class="mdl-layout-title">Управление</span>
            <nav class="mdl-navigation">
                <a class="mdl-navigation__link wave-effect" href="index.php">главная</a>
                <a class="mdl-navigation__link wave-effect" href="profile.php?login=<?php echo $Login ?>">профиль</a>
                <a class="mdl-navigation__link wave-effect" href="">общая статистика</a>
                <a class="mdl-navigation__link wave-effect" href="">класс</a>
                <a class="mdl-navigation__link wave-effect" href="">достижения</a>
                <a class="mdl-navigation__link wave-effect" href="exit.php">выйти</a>
            </nav>
        </div>
        <main class="mdl-layout__content">
            <div class="page-content mdl-grid">
                <div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--3-col-desktop mdl-cell--3-offset-desktop">
                    <div class="mdl-card mdl-shadow--6dp">
                        <div class="mdl-card__title mdl-card--border">
                            <div class="mdl-card__title-text" style="text-transform: none">Название участника</div>
                        </div>
                        <div class="mdl-card__title">
                            <div class="card_field">
                                <i id="participant" class="fa fa-user-circle-o"></i>
                                <div class="mdl-tooltip" for="participant">
                                    Тот, кому выставляют баллы,<br>например: участник, ученик...
                                </div>
                                <div class="card_field_text">
                                    Участник
                                </div>
                            </div>
                        </div>
                        <div class="mdl-card__menu">
                            <button class="mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect"
                                    id="button_login">
                                <i class="material-icons">create</i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--3-col-desktop">
                    <div class="mdl-card mdl-shadow--6dp">
                        <div class="mdl-card__title mdl-card--border">
                            <div class="mdl-card__title-text">пароль</div>
                        </div>
                        <div class="mdl-card__title">
                            <div class="card_field">
                                <i class="fa fa-key"></i>
                                <div class="card_field_text">
                                    XXXXXX
                                </div>
                            </div>
                        </div>
                        <div class="mdl-card__menu">
                            <button class="mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect"
                                    id="button_password">
                                <i class="material-icons">create</i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="mdl-cell mdl-cell--3-col-desktop mdl-cell--hide-tablet mdl-cell--hide-phone"></div>
            </div>
        </main>
    </div>
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <!-- MDL -->
    <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
    <!-- Notie.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/notie/3.9.5/notie.min.js"></script>
    <!-- WaveEffect -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/node-waves/0.7.5/waves.min.js"></script>
    <!-- MaterialPreloader -->
    <script type="text/javascript" src="scripts/js/materialPreloader.min.js"></script>
    <!-- Other scripts -->
    <script src="scripts/js/orgset.js"></script>
    <script type="text/javascript" src="scripts/js/waveeffect.js"></script>
    </body>
    </html>
<?php endif ?>
