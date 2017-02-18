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
$Functions = $Request->GetFunctionsValues();
$Categories = $Request->GetCategories();
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
        <!-- ResponsiveTable -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ReStable/0.1.2/jquery.restable.min.css">
        <!--[if IE]>
        <script src="//cdnjs.cloudflare.com/ajax/libs/es5-shim/4.2.0/es5-shim.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/classlist/2014.01.31/classList.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/selectivizr/1.0.2/selectivizr-min.js"></script>
        <![endif]-->
    </head>
    <body>
    <div class="on_edit mdl-grid" id="participant_name_edit">
        <div class="on_edit-click" id="on_edit-participant_name_edit"></div>
        <div class="mdl-grid mdl-cell mdl-cell-middle mdl-cell--12-col">
            <div class="mdl-cell mdl-cell--middle mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--4-col-desktop mdl-cell--4-offset-desktop">
                <div class="mdl-card mdl-shadow--6dp on_edit-card">
                    <div class="mdl-card__title mdl-card--border">
                        <div class="mdl-card__title-text" style="text-transform: none">Название участника</div>
                    </div>
                    <div class="mdl-card__title">
                        <div class="card_field">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"
                                 id="participant_name_input">
                                <input class="mdl-textfield__input" type="text" id="participant_name">
                                <label class="mdl-textfield__label" for="participant_name">Участник смены,
                                    ученик...</label>
                            </div>
                        </div>
                    </div>
                    <div class="mdl-card__actions mdl-card--border">
                        <button class="mdl-button mdl-button--colored mdl-button--primary mdl-js-button mdl-js-ripple-effect on_edit-card-confirm"
                                id="participant_name_edit-confirm">
                            сохранить
                        </button>
                        <button class="mdl-button mdl-button--colored mdl-button--accent mdl-js-button mdl-js-ripple-effect on_edit-card-cancel"
                                id="participant_name_edit-cancel">
                            отмена
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="on_edit mdl-grid" id="team_name_edit">
        <div class="on_edit-click" id="on_edit-team_name_edit"></div>
        <div class="mdl-grid mdl-cell mdl-cell-middle mdl-cell--12-col">
            <div class="mdl-cell mdl-cell--middle mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--4-col-desktop mdl-cell--4-offset-desktop">
                <div class="mdl-card mdl-shadow--6dp on_edit-card">
                    <div class="mdl-card__title mdl-card--border">
                        <div class="mdl-card__title-text" style="text-transform: none">Название команд</div>
                    </div>
                    <div class="mdl-card__title">
                        <div class="card_field">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"
                                 id="team_name_input">
                                <input class="mdl-textfield__input" type="text" id="team_name">
                                <label class="mdl-textfield__label" for="team_name">Группа, команда, класс...</label>
                            </div>
                        </div>
                    </div>
                    <div class="mdl-card__actions mdl-card--border">
                        <button class="mdl-button mdl-button--colored mdl-button--primary mdl-js-button mdl-js-ripple-effect on_edit-card-confirm"
                                id="team_name_edit-confirm">
                            сохранить
                        </button>
                        <button class="mdl-button mdl-button--colored mdl-button--accent mdl-js-button mdl-js-ripple-effect on_edit-card-cancel"
                                id="team_name_edit-cancel">
                            отмена
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="on_edit mdl-grid" id="organization_name_edit">
        <div class="on_edit-click" id="on_edit-organization_name_edit"></div>
        <div class="mdl-grid mdl-cell mdl-cell-middle mdl-cell--12-col">
            <div class="mdl-cell mdl-cell--middle mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--4-col-desktop mdl-cell--4-offset-desktop">
                <div class="mdl-card mdl-shadow--6dp on_edit-card">
                    <div class="mdl-card__title mdl-card--border">
                        <div class="mdl-card__title-text" style="text-transform: none">Название организации</div>
                    </div>
                    <div class="mdl-card__title">
                        <div class="card_field">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"
                                 id="organization_name_input">
                                <input class="mdl-textfield__input" type="text" id="organization_name">
                                <label class="mdl-textfield__label" for="organization_name">Название вашей
                                    организации</label>
                            </div>
                        </div>
                    </div>
                    <div class="mdl-card__actions mdl-card--border">
                        <button class="mdl-button mdl-button--colored mdl-button--primary mdl-js-button mdl-js-ripple-effect on_edit-card-confirm"
                                id="organization_name_edit-confirm">
                            сохранить
                        </button>
                        <button class="mdl-button mdl-button--colored mdl-button--accent mdl-js-button mdl-js-ripple-effect on_edit-card-cancel"
                                id="organization_name_edit-cancel">
                            отмена
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="on_edit mdl-grid" id="period_name_edit">
        <div class="on_edit-click" id="on_edit-period_name_edit"></div>
        <div class="mdl-grid mdl-cell mdl-cell-middle mdl-cell--12-col">
            <div class="mdl-cell mdl-cell--middle mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--4-col-desktop mdl-cell--4-offset-desktop">
                <div class="mdl-card mdl-shadow--6dp on_edit-card">
                    <div class="mdl-card__title mdl-card--border">
                        <div class="mdl-card__title-text" style="text-transform: none">Название периода</div>
                    </div>
                    <div class="mdl-card__title">
                        <div class="card_field">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"
                                 id="period_name_input">
                                <input class="mdl-textfield__input" type="text" id="period_name">
                                <label class="mdl-textfield__label" for="period_name">1 четверть, 1 смена...</label>
                            </div>
                        </div>
                    </div>
                    <div class="mdl-card__actions mdl-card--border">
                        <button class="mdl-button mdl-button--colored mdl-button--primary mdl-js-button mdl-js-ripple-effect on_edit-card-confirm"
                                id="period_name_edit-confirm">
                            сохранить
                        </button>
                        <button class="mdl-button mdl-button--colored mdl-button--accent mdl-js-button mdl-js-ripple-effect on_edit-card-cancel"
                                id="period_name_edit-cancel">
                            отмена
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="on_edit mdl-grid" id="categories_adding">
        <div class="on_edit-click" id="on_edit-categories_adding"></div>
        <div class="mdl-grid mdl-cell mdl-cell-middle mdl-cell--12-col">
            <div class="mdl-cell mdl-cell--middle mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--4-col-desktop mdl-cell--4-offset-desktop">
                <div class="mdl-card mdl-shadow--6dp on_edit-card">
                    <div class="mdl-card__title mdl-card--border">
                        <div class="mdl-card__title-text" style="text-transform: none">Название категории</div>
                    </div>
                    <div class="mdl-card__title">
                        <div class="card_field">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"
                                 id="categories_input">
                                <input class="mdl-textfield__input" type="text" id="categories">
                                <label class="mdl-textfield__label" for="categories">Спорт, учёба, дисциплина...</label>
                            </div>
                        </div>
                    </div>
                    <div class="mdl-card__actions mdl-card--border">
                        <button class="mdl-button mdl-button--colored mdl-button--primary mdl-js-button mdl-js-ripple-effect on_edit-card-confirm--effect"
                                id="categories_adding-confirm">
                            сохранить
                        </button>
                        <button class="mdl-button mdl-button--colored mdl-button--accent mdl-js-button mdl-js-ripple-effect on_edit-card-cancel--effect"
                                id="categories_adding-cancel">
                            отмена
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="on_edit mdl-grid" id="participants_adding">
        <div class="on_edit-click"></div>
        <div class="mdl-grid mdl-cell mdl-cell-middle mdl-cell--12-col">
            <div class="mdl-cell mdl-cell--middle mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--4-col-desktop mdl-cell--4-offset-desktop">
                <div class="mdl-card mdl-shadow--6dp on_edit-card">
                    <div class="mdl-card__title mdl-card--border">
                        <div class="mdl-card__title-text" style="text-transform: none">Добавление участника</div>
                    </div>
                    <div class="mdl-card__title">
                        <div class="card_field">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"
                                 id="participants_adding_name_input">
                                <input class="mdl-textfield__input" type="text" id="participants_adding_name">
                                <label class="mdl-textfield__label" for="participants_adding_name">Имя участника</label>
                            </div>
                        </div>
                    </div>
                    <div class="mdl-card__title">
                        <div class="card_field">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"
                                 id="participants_adding_surname_input">
                                <input class="mdl-textfield__input" type="text" id="participants_adding_surname">
                                <label class="mdl-textfield__label" for="participants_adding_surname">Фамилия
                                    участника</label>
                            </div>
                        </div>
                    </div>
                    <div class="mdl-card__title">
                        <div class="card_field">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"
                                 id="participants_adding_middlename_input">
                                <input class="mdl-textfield__input" type="text" id="participants_adding_middlename">
                                <label class="mdl-textfield__label" for="participants_adding_middlename">Отчество
                                    участника</label>
                            </div>
                        </div>
                    </div>
                    <div class="mdl-card__title">
                        <div class="card_field">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"
                                 id="participants_adding_sex_input">
                                <input class="mdl-textfield__input" type="text" id="participants_adding_sex">
                                <label class="mdl-textfield__label" for="participants_adding_sex">Пол участника</label>
                            </div>
                        </div>
                    </div>
                    <div class="mdl-card__title mdl-card--border">
                        <div class="card_field">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"
                                 id="participants_adding_team_input">
                                <input class="mdl-textfield__input" type="text" id="participants_adding_team">
                                <label class="mdl-textfield__label" for="participants_adding_team">Команда
                                    участника</label>
                            </div>
                        </div>
                    </div>
                    <div class="mdl-card__actions mdl-card--border">
                        <button class="mdl-button mdl-button--colored mdl-button--primary mdl-js-button mdl-js-ripple-effect on_edit-card-confirm-effect"
                                id="participants_adding-confirm">
                            сохранить
                        </button>
                        <button class="mdl-button mdl-button--colored mdl-button--accent mdl-js-button mdl-js-ripple-effect on_edit-card-cancel-effect"
                                id="participants_adding-cancel">
                            отмена
                        </button>
                        <button class="mdl-button mdl-button--colored mdl-button--primary mdl-js-button mdl-js-ripple-effect on_edit-card-cancel-effect"
                                id="participants_adding-file" style="float:right">
                            загрузить файл
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="on_edit mdl-grid" id="participants_adding_file">
        <div class="on_edit-click"></div>
        <div class="mdl-grid mdl-cell mdl-cell-middle mdl-cell--12-col">
            <div class="mdl-cell mdl-cell--middle mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--4-col-desktop mdl-cell--4-offset-desktop">
                <div class="mdl-card mdl-shadow--6dp on_edit-card">
                    <div class="mdl-card__title mdl-card--border">
                        <div class="mdl-card__title-text" style="text-transform: none">Добавление участников</div>
                    </div>
                    <div class="mdl-card__actions">
                        <div class="card_field">
                            <form method="post" name="participants_upload" enctype="multipart/form-data">
                                <input type="file" accept=".xlsx" name="uploadfile">
                                <input type="submit" value="загрузить">
                            </form>
                        </div>
                    </div>
                    <div class="mdl-card__menu">
                        <button class="mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect"
                                id="button_participants_file">
                            <i class="material-icons">cloud_download</i>
                        </button>
                        <div class="mdl-tooltip mdl-tooltip--left" for="button_participants_file">
                            Скачать шаблон
                        </div>
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
            <div class="mdl-layout__tab-bar mdl-js-ripple-effect">
                <a href="#orgset_main" class="mdl-layout__tab is-active">Основные настройки</a>
                <a href="#orgset_participants" class="mdl-layout__tab">Участники</a>
                <a href="#orgset_employees" class="mdl-layout__tab">Сотрудники</a>
                <a href="#orgset_achievements" class="mdl-layout__tab">Достижения</a>
                <a href="#orgset_actions" class="mdl-layout__tab">События</a>
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
            <!-- Main settings -->
            <section class="mdl-layout__tab-panel is-active" id="orgset_main">
                <div class="page-content mdl-grid">
                    <div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--4-col-desktop mdl-cell--2-offset-desktop">
                        <div class="mdl-card mdl-shadow--6dp">
                            <div class="mdl-card__title mdl-card--border">
                                <div class="mdl-card__title-text" style="text-transform: none">Название участника</div>
                            </div>
                            <div class="mdl-card__title">
                                <div class="card_field">
                                    <i class="fa fa-user-circle-o"></i>
                                    <div class="card_field_text" id="participant_field">
                                        <?php echo $Functions["participant"]["Value"] ?>
                                    </div>
                                </div>
                            </div>
                            <div class="mdl-card__menu">
                                <button class="mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect on_edit-activation"
                                        id="participant_name_edit_activation">
                                    <i class="material-icons">create</i>
                                </button>
                                <div class="mdl-tooltip mdl-tooltip--left" for="participant_name_edit_activation">
                                    Тот, кому выставляют баллы,<br>например: участник, ученик...
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--4-col-desktop">
                        <div class="mdl-card mdl-shadow--6dp">
                            <div class="mdl-card__title mdl-card--border">
                                <div class="mdl-card__title-text" style="text-transform: none">Название команд</div>
                            </div>
                            <div class="mdl-card__title">
                                <div class="card_field">
                                    <i class="fa fa-users"></i>
                                    <div class="card_field_text" id="team_field">
                                        <?php echo $Functions["team"]["Value"] ?>
                                    </div>
                                </div>
                            </div>
                            <div class="mdl-card__menu">
                                <button class="mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect on_edit-activation"
                                        id="team_name_edit_activation">
                                    <i class="material-icons">create</i>
                                </button>
                                <div class="mdl-tooltip mdl-tooltip--left" for="team_name_edit_activation">
                                    Объединения участников,<br>например: группа, класс...
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mdl-cell mdl-cell--2-col-desktop mdl-cell--hide-tablet mdl-cell--hide-phone"></div>
                    <!-- Next level -->
                    <div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--4-col-desktop mdl-cell--2-offset-desktop">
                        <div class="mdl-card mdl-shadow--6dp">
                            <div class="mdl-card__title mdl-card--border">
                                <div class="mdl-card__title-text" style="text-transform: none">Организация</div>
                            </div>
                            <div class="mdl-card__title">
                                <div class="card_field">
                                    <i class="fa fa-university"></i>
                                    <div class="card_field_text" id="organization_field">
                                        <?php echo $Functions["org"]["Value"] ?>
                                    </div>
                                </div>
                            </div>
                            <div class="mdl-card__menu">
                                <button class="mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect on_edit-activation"
                                        id="organization_name_edit_activation">
                                    <i class="material-icons">create</i>
                                </button>
                                <div class="mdl-tooltip mdl-tooltip--left" for="organization_name_edit_activation">
                                    Название вашей организации
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--4-col-desktop">
                        <div class="mdl-card mdl-shadow--6dp">
                            <div class="mdl-card__title mdl-card--border">
                                <div class="mdl-card__title-text" style="text-transform: none">Название периода</div>
                            </div>
                            <div class="mdl-card__title">
                                <div class="card_field">
                                    <i class="fa fa-calendar-o"></i>
                                    <div class="card_field_text" id="period_field">
                                        <?php echo $Functions["period"]["Value"] ?>
                                    </div>
                                </div>
                            </div>
                            <div class="mdl-card__menu">
                                <button class="mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect on_edit-activation"
                                        id="period_name_edit_activation">
                                    <i class="material-icons">create</i>
                                </button>
                                <div class="mdl-tooltip mdl-tooltip--left" for="period_name_edit_activation">
                                    Только для итоговой статистики,<br>например: 4 четверь, 1 смена...
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mdl-cell mdl-cell--2-col-desktop mdl-cell--hide-tablet mdl-cell--hide-phone"></div>
                    <!-- Next level -->
                    <div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--4-col-desktop mdl-cell--2-offset-desktop">
                        <div class="mdl-card mdl-shadow--6dp" id="categories_list">
                            <div class="mdl-card__title mdl-card--border">
                                <div class="mdl-card__title-text" style="text-transform: none">Категории</div>
                            </div>
                            <?php
                            for ($i = 0; $i < $Categories['val']; $i++) {
                                echo " <div class='mdl-card__title mdl-card--border' id='" . str_replace(' ', "_", $Categories[$i]["Value"]) . "_row'>";
                                echo "<div class='card_field'>";
                                echo "<i class='material-icons'>more_vert</i>";
                                echo "<div class='card_field_text category_name'>" . $Categories[$i]["Value"];
                                echo "</div></div>";
                                echo "<button class='mdl-button mdl-js-button mdl-button--icon mdl-button--colored mdl-button--accent category-delete' id='" . str_replace(' ', "_", $Categories[$i]["Value"]) . "'>";
                                echo "<i class='material-icons'>clear</i></button>";
                                echo "</div>";
                            }
                            ?>
                            <div class="mdl-card__menu">
                                <button class="mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-button--primary"
                                        id="categories-add">
                                    <i class="material-icons">add</i>
                                </button>
                                <div class="mdl-tooltip mdl-tooltip--left" for="categories-add">
                                    Категории оценивания,<br>например: учёба, спорт...
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--4-col-desktop">
                        <div class="mdl-card mdl-shadow--6dp">
                            <div class="mdl-card__title mdl-card--border">
                                <div class="mdl-card__title-text" style="text-transform: none">Основные настройки</div>
                            </div>
                            <div class="mdl-card__title">
                            </div>
                        </div>
                    </div>
                    <div class="mdl-cell mdl-cell--2-col-desktop mdl-cell--hide-tablet mdl-cell--hide-phone"></div>
                </div>
            </section>
            <!-- Participants -->
            <section class="mdl-layout__tab-panel" id="orgset_participants">
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
                                        <th class="mdl-data-table__cell--non-numeric">Пол</th>
                                        <th class="mdl-data-table__cell--non-numeric">Класс</th>
                                        <?php
                                        for ($i = 0; $i < $Categories['val']; $i++) {
                                            echo "<th>" . $Categories[$i]["Value"] . "</th>";
                                        }
                                        ?>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="mdl-data-table__cell--non-numeric">Иванов Никита Сергеевич</td>
                                        <td class="mdl-data-table__cell--non-numeric">Мужской</td>
                                        <td class="mdl-data-table__cell--non-numeric">11А</td>
                                        <td>25</td>
                                        <td>25</td>
                                        <td>25</td>
                                        <td>25</td>
                                    </tr>
                                    <tr>
                                        <td class="mdl-data-table__cell--non-numeric">Иванов Иван Иванович</td>
                                        <td class="mdl-data-table__cell--non-numeric">Мужской</td>
                                        <td class="mdl-data-table__cell--non-numeric">10Б</td>
                                        <td>50</td>
                                        <td>50</td>
                                        <td>50</td>
                                        <td>50</td>
                                    </tr>
                                    <tr>
                                        <td class="mdl-data-table__cell--non-numeric">Иванов Иван Иванович</td>
                                        <td class="mdl-data-table__cell--non-numeric">Мужской</td>
                                        <td class="mdl-data-table__cell--non-numeric">10А</td>
                                        <td>10</td>
                                        <td>10</td>
                                        <td>10</td>
                                        <td>10</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mdl-card__menu">
                                <button class="mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-button--colored mdl-button--primary"
                                        id="button_participants">
                                    <i class="material-icons">add</i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Employees -->
            <section class="mdl-layout__tab-panel" id="orgset_employees">
                <div class="page-content mdl-grid">
                    <div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop mdl-cell--3-offset-desktop">
                        <div class="mdl-card mdl-shadow--6dp">
                            <div class="mdl-card__title mdl-card--border">
                                <div class="mdl-card__title-text" style="text-transform: none">Персонал</div>
                            </div>
                            <div class="mdl-card__title">
                            </div>
                            <div class="mdl-card__menu">
                                <button class="mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect"
                                        id="button_employees">
                                    <i class="material-icons">create</i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Achievements -->
            <section class="mdl-layout__tab-panel" id="orgset_achievements">
                <div class="page-content mdl-grid">
                    <div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop mdl-cell--3-offset-desktop">
                        <div class="mdl-card mdl-shadow--6dp">
                            <div class="mdl-card__title mdl-card--border">
                                <div class="mdl-card__title-text" style="text-transform: none">Достижения</div>
                            </div>
                            <div class="mdl-card__title">
                            </div>
                            <div class="mdl-card__menu">
                                <button class="mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect"
                                        id="button_employees">
                                    <i class="material-icons">create</i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Actions -->
            <section class="mdl-layout__tab-panel" id="orgset_actions">
                <div class="page-content mdl-grid">
                    <div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop mdl-cell--3-offset-desktop">
                        <div class="mdl-card mdl-shadow--6dp">
                            <div class="mdl-card__title mdl-card--border">
                                <div class="mdl-card__title-text" style="text-transform: none">События</div>
                            </div>
                            <div class="mdl-card__title">
                            </div>
                            <div class="mdl-card__menu">
                                <button class="mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect"
                                        id="button_employees">
                                    <i class="material-icons">create</i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
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
    <script src="scripts/js/orgset.js"></script>
    <script type="text/javascript" src="scripts/js/waveeffect.js"></script>
    </body>
    </html>
<?php endif ?>
