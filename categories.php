<?php

require_once "scripts/php/userdata.php";

$sid = filter_input(INPUT_COOKIE, 'sid');
if (!isset($sid)) {
    header("Location: index.php");
}
$Request = new UserData($sid, NULL, TRUE);
$RequestData = $Request->GetUserData();
if ($RequestData['accesslevel'] === "participant") {
    header("Location: index.php");
}
$Login = $Request->GetUserLogin();
$UserData = $Request->GetUserData();
$Participants = $Request->GetParticipants();
$Functions = $Request->GetFunctionsValues();
$Categories = $Request->GetCategories();
$Organization = $Request->GetUserOrganization_Eng();
?>
<?php if (isset($sid) && $RequestData['accesslevel'] === "admin" || "employee"): ?>
    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ForCamp | Панель управления</title>
        <link rel="stylesheet" href="scss/categories.css">
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
        <!-- ResponsiveTable -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ReStable/0.1.2/jquery.restable.min.css">
        <!--[if IE]>
        <script src="//cdnjs.cloudflare.com/ajax/libs/es5-shim/4.2.0/es5-shim.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/classlist/2014.01.31/classList.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/selectivizr/1.0.2/selectivizr-min.js"></script>
        <![endif]-->
    </head>
    <body>
    <div class="on_edit mdl-grid" id="participant_mark_edit">
        <div class="on_edit-click" id="on_edit-participant_name_edit"></div>
        <div class="mdl-grid mdl-cell mdl-cell-middle mdl-cell--12-col">
            <div class="mdl-cell mdl-cell--middle mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--4-col-desktop mdl-cell--4-offset-desktop">
                <div class="mdl-card mdl-shadow--6dp on_edit-card">
                    <div class="mdl-card__title mdl-card--border">
                        <div class="mdl-card__title-text" id="participant_mark_edit_title" style="text-transform: none">Название участника</div>
                    </div>
                    <div class="mdl-card__title">
                        <div class="card_field">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"
                                 id="participant_mark_input">
                                <input class="mdl-textfield__input" type="number" id="participant_mark">
                                <label class="mdl-textfield__label" for="participant_mark">Введите изменение, например: 10 или -10</label>
                            </div>
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"
                                 id="participant_reason_input">
                                <input class="mdl-textfield__input" type="text" id="participant_reason">
                                <label class="mdl-textfield__label" for="participant_reason">Введите причину изменения</label>
                            </div>
                        </div>
                    </div>
                    <div class="mdl-card__actions mdl-card--border">
                        <button class="mdl-button mdl-button--colored mdl-button--primary mdl-js-button mdl-js-ripple-effect on_edit-card-confirm"
                                id="participant_mark_edit-confirm">
                            сохранить
                        </button>
                        <button class="mdl-button mdl-button--colored mdl-button--accent mdl-js-button mdl-js-ripple-effect on_edit-card-cancel"
                                id="participant_mark_edit-cancel">
                            отмена
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
        <header class="mdl-layout__header">
            <div class="mdl-layout__header-row">
                <span class="mdl-layout-title"><?php echo $RequestData['organization'] ?></span>
            </div>
        </header>
        <div class="mdl-layout__drawer">
            <span class="mdl-layout-title">Баллы</span>
            <nav class="mdl-navigation">
                <a class="mdl-navigation__link wave-effect" href="index.php">главная</a>
                <a class="mdl-navigation__link wave-effect" href="profile.php?login=<?php echo $Login ?>">профиль</a>
                <?php if ($RequestData['accesslevel'] === "admin"): ?>
                    <a class="mdl-navigation__link wave-effect" href="orgset.php">управление</a>
                <?php endif ?>
                <a class="mdl-navigation__link wave-effect" href="">общая статистика</a>
                <a class="mdl-navigation__link wave-effect" href="">класс</a>
                <a class="mdl-navigation__link wave-effect" href="">достижения</a>
                <a class="mdl-navigation__link wave-effect" href="exit.php">выйти</a>
            </nav>
        </div>
        <main class="mdl-layout__content">
            <div class="page-content mdl-grid">
                <div class="mdl-cell mdl-cell--12-col">
                    <div class="mdl-card mdl-shadow--6dp">
                        <div class="mdl-card__title">
                            <div class="mdl-card__title-text" style="text-transform: none">Участники</div>
                        </div>
                        <div class="mdl-card__title" id="participants_card">
                            <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp"
                                   id="participants_card_table">
                                <thead>
                                <tr>
                                    <th class="mdl-data-table__cell--non-numeric">ФИО</th>
                                    <th class="mdl-data-table__cell--non-numeric"
                                        style="text-transform: capitalize"><?php echo $Functions["team"]["Value"] ?></th>
                                    <?php
                                    for ($i = 0; $i < $Categories['val']; $i++) {
                                        echo "<th>" . $Categories[$i]["Value"] . "</th>";
                                    }
                                    ?>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                for ($i = 0; $i < $Participants["val"]; $i++) {
                                    echo "<tr>";
                                    echo "<td class='mdl-data-table__cell--non-numeric' id='" . $Participants[$i]["Login"] . "'><a href='profile.php?login=" . $Participants[$i]["Login"] . "'>" . $Participants[$i]["surname"] . " " .
                                        $Participants[$i]["name"] . " " . $Participants[$i]["middlename"] . "</a></td>";
                                    echo "<td class='mdl-data-table__cell--non-numeric'>" . $Participants[$i]["team"] . "</td>";
                                    for ($c = 0; $c < $Categories['val']; $c++) {
                                        if($UserData[$Categories[$c]["Key"]] == 1 || $UserData["accesslevel"] === "admin"){
                                            if($UserData["team"] == $Participants[$i]["team"] && $Functions["team_leader"]["Value"] == 0){
                                                echo "<td class='participant_mark' id='participant-mark-".$Participants[$i]["Login"]."-".$Categories[$c]["Key"]."'team_disabled>" . $Participants[$i][$Categories[$c]["Key"]] . "</td>";
                                            } else {
                                                echo "<td class='participant_mark' id='participant-mark-" . $Participants[$i]["Login"] . "-" . $Categories[$c]["Key"] . "'>" . $Participants[$i][$Categories[$c]["Key"]] . "</td>";
                                            }
                                        } else {
                                            echo "<td class='participant_mark' id='participant-mark-".$Participants[$i]["Login"]."-".$Categories[$c]["Key"]."'disabled>" . $Participants[$i][$Categories[$c]["Key"]] . "</td>";
                                        }
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="mdl-card__menu">
                            <button class="mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-button--colored mdl-button--primary"
                                    id="button_participants">
                                <i class="material-icons">create</i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
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
    <!-- ResponsiveTable -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ReStable/0.1.2/jquery.restable.min.js"></script>
    <!-- Other scripts -->
    <script src="scripts/js/categories.js"></script>
    <script type="text/javascript" src="scripts/js/waveeffect.js"></script>
    </body>
    </html>
<?php endif ?>
