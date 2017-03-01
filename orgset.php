<?php

require_once "scripts/php/userdata.php";
require_once "scripts/php/phpmorphy/src/common.php";

$MorphyDir = "scripts/php/phpmorphy/dicts";
$Lang = "ru_RU";

$Morphy = new phpMorphy($MorphyDir, $Lang);

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
$Participants = $Request->GetParticipants();
$Employees = $Request->GetEmployees();
$Functions = $Request->GetFunctionsValues();
$Categories = $Request->GetCategories();
$Organization = $Request->GetUserOrganization_Eng();
$Actions = $Request->GetActions();
$Teams = $Request->GetTeams();
?>
<?php if (isset($sid) && $RequestData['accesslevel'] === "admin"): ?>
    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ForCamp | Панель управления</title>
        <link rel="stylesheet" href="scss/orgset.css">
        <!-- MDL -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-red.min.css"/>
        <link rel="stylesheet" href="scss/mdl-selectfield.css">
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
    <div class="on_edit mdl-grid" id="categories_editing">
        <div class="on_edit-click" id="on_edit-categories_editing"></div>
        <div class="mdl-grid mdl-cell mdl-cell-middle mdl-cell--12-col">
            <div class="mdl-cell mdl-cell--middle mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--4-col-desktop mdl-cell--4-offset-desktop">
                <div class="mdl-card mdl-shadow--6dp on_edit-card">
                    <div class="mdl-card__title mdl-card--border">
                        <div class="mdl-card__title-text" style="text-transform: none">Название категории</div>
                    </div>
                    <div class="mdl-card__title">
                        <div class="card_field">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"
                                 id="categories_editing_input">
                                <input class="mdl-textfield__input" type="text" id="categories-editing">
                                <label class="mdl-textfield__label" for="categories-editing">Введите новое название
                                    категории</label>
                            </div>
                        </div>
                    </div>
                    <div class="mdl-card__actions mdl-card--border">
                        <button class="mdl-button mdl-button--colored mdl-button--primary mdl-js-button mdl-js-ripple-effect on_edit-card-confirm--effect"
                                id="categories_editing-confirm">
                            сохранить
                        </button>
                        <button class="mdl-button mdl-button--colored mdl-button--accent mdl-js-button mdl-js-ripple-effect on_edit-card-cancel--effect"
                                id="categories_editing-cancel">
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
                        <div class="mdl-card__title-text" style="text-transform: none">
                            Добавление <?php echo mb_strtolower($Morphy->castFormByGramInfo(mb_strtoupper($Functions["participant"]["Value"]), null, ['РД', 'ЕД'], TRUE)[0]) ?></div>
                    </div>
                    <div class="mdl-card__title">
                        <div class="card_field">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"
                                 id="participants_adding_name_input">
                                <input class="mdl-textfield__input" type="text" id="participants_adding_surname">
                                <label class="mdl-textfield__label"
                                       for="participants_adding_surname">Фамилия <?php echo mb_strtolower($Morphy->castFormByGramInfo(mb_strtoupper($Functions["participant"]["Value"]), null, ['РД', 'ЕД'], TRUE)[0]) ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="mdl-card__title">
                        <div class="card_field">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"
                                 id="participants_adding_surname_input">
                                <input class="mdl-textfield__input" type="text" id="participants_adding_name">
                                <label class="mdl-textfield__label" for="participants_adding_name">Имя
                                    <?php echo mb_strtolower($Morphy->castFormByGramInfo(mb_strtoupper($Functions["participant"]["Value"]), null, ['РД', 'ЕД'], TRUE)[0]) ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="mdl-card__title">
                        <div class="card_field">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"
                                 id="participants_adding_middlename_input">
                                <input class="mdl-textfield__input" type="text" id="participants_adding_middlename">
                                <label class="mdl-textfield__label" for="participants_adding_middlename">Отчество
                                    <?php echo mb_strtolower($Morphy->castFormByGramInfo(mb_strtoupper($Functions["participant"]["Value"]), null, ['РД', 'ЕД'], TRUE)[0]) ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="mdl-card__title">
                        <div class="card_field">
                            <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect"
                                   for="participants_adding_sex-male">
                                <input type="radio" id="participants_adding_sex-male" class="mdl-radio__button"
                                       name="participants_adding_sex" value="мужской" checked>
                                <span class="mdl-radio__label">Мужской</span>
                            </label>
                            <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect"
                                   for="participants_adding_sex-female">
                                <input type="radio" id="participants_adding_sex-female" class="mdl-radio__button"
                                       name="participants_adding_sex" value="женский">
                                <span class="mdl-radio__label">Женский</span>
                            </label>
                        </div>
                    </div>
                    <div class="mdl-card__title mdl-card--border">
                        <div class="card_field">
                            <div class="mdl-selectfield mdl-js-selectfield">
                                <select id="participants_adding_team" name="participant_team" class="mdl-selectfield__select">
                                    <?php
                                    for($i = 0; $i < count($Teams); $i++){
                                        echo "<option value='".$Teams[$i]["Name"]."'>".$Teams[$i]["Name"]."</option>";
                                    }
                                    ?>
                                </select>
                                <label class="mdl-selectfield__label" for="participants_adding_team"><?php echo $Functions["team"]["Value"]?></label>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="on_edit mdl-grid" id="employees_adding">
        <div class="on_edit-click"></div>
        <div class="mdl-grid mdl-cell mdl-cell-middle mdl-cell--12-col">
            <div class="mdl-cell mdl-cell--middle mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--4-col-desktop mdl-cell--4-offset-desktop">
                <div class="mdl-card mdl-shadow--6dp on_edit-card">
                    <div class="mdl-card__title mdl-card--border">
                        <div class="mdl-card__title-text" style="text-transform: none">Добавление сотрудника</div>
                    </div>
                    <div class="mdl-card__title">
                        <div class="card_field">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"
                                 id="employees_adding_name_input">
                                <input class="mdl-textfield__input" type="text" id="employees_adding_surname">
                                <label class="mdl-textfield__label" for="employees_adding_surname">Фамилия
                                    сотрудника</label>
                            </div>
                        </div>
                    </div>
                    <div class="mdl-card__title">
                        <div class="card_field">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"
                                 id="employees_adding_surname_input">
                                <input class="mdl-textfield__input" type="text" id="employees_adding_name">
                                <label class="mdl-textfield__label" for="employees_adding_name">Имя
                                    сотрудника</label>
                            </div>
                        </div>
                    </div>
                    <div class="mdl-card__title">
                        <div class="card_field">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"
                                 id="employees_adding_middlename_input">
                                <input class="mdl-textfield__input" type="text" id="employees_adding_middlename">
                                <label class="mdl-textfield__label" for="employees_adding_middlename">Отчество
                                    сотрудника</label>
                            </div>
                        </div>
                    </div>
                    <div class="mdl-card__title">
                        <div class="card_field">
                            <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="employee_adding_sex-male">
                                <input type="radio" id="employee_adding_sex-male" class="mdl-radio__button"
                                       name="employee_adding_sex" value="мужской" checked>
                                <span class="mdl-radio__label">Мужской</span>
                            </label>
                            <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="employee_adding_sex-female">
                                <input type="radio" id="employee_adding_sex-female" class="mdl-radio__button"
                                       name="employee_adding_sex" value="женский">
                                <span class="mdl-radio__label">Женский</span>
                            </label>
                        </div>
                    </div>
                    <div class="mdl-card__title">
                        <div class="card_field">
                            <div class="mdl-selectfield mdl-js-selectfield">
                                <select id="employees_adding_team" name="employees_adding_team" class="mdl-selectfield__select">
                                    <option value="не указан">Не указан</option>
                                    <?php
                                    for($i = 0; $i < count($Teams); $i++){
                                        echo "<option value='".$Teams[$i]["Name"]."'>".$Teams[$i]["Name"]."</option>";
                                    }
                                    ?>
                                </select>
                                <label class="mdl-selectfield__label" for="employees_adding_team"><?php echo $Functions["team"]["Value"]?></label>
                            </div>
                        </div>
                    </div>
                    <div class="mdl-card__title mdl-card--border">
                        <div class="card_field">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"
                                 id="employees_adding_post_input">
                                <input class="mdl-textfield__input" type="text" id="employees_adding_post">
                                <label class="mdl-textfield__label" for="employees_adding_post">Должность
                                    сотрудника</label>
                            </div>
                        </div>
                    </div>
                    <div class="mdl-card__actions mdl-card--border">
                        <button class="mdl-button mdl-button--colored mdl-button--primary mdl-js-button mdl-js-ripple-effect on_edit-card-confirm-effect"
                                id="employees_adding-confirm">
                            сохранить
                        </button>
                        <button class="mdl-button mdl-button--colored mdl-button--accent mdl-js-button mdl-js-ripple-effect on_edit-card-cancel-effect"
                                id="employees_adding-cancel">
                            отмена
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="on_edit mdl-grid" id="participants_editing">
        <div class="on_edit-click"></div>
        <div class="mdl-grid mdl-cell mdl-cell-middle mdl-cell--12-col">
            <div class="mdl-cell mdl-cell--middle mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--4-col-desktop mdl-cell--4-offset-desktop">
                <div class="mdl-card mdl-shadow--6dp on_edit-card">
                    <div class="mdl-card__title mdl-card--border">
                        <div class="mdl-card__title-text" style="text-transform: none">Изменение
                            данных <?php echo mb_strtolower($Morphy->castFormByGramInfo(mb_strtoupper($Functions["participant"]["Value"]), null, ['РД', 'ЕД'], TRUE)[0]) ?></div>
                    </div>
                    <div class="mdl-card__title">
                        <div class="card_field">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"
                                 id="participants_editing_name_input">
                                <input class="mdl-textfield__input" type="text" id="participants_editing_surname">
                                <label class="mdl-textfield__label" for="participants_editing_surname">Фамилия
                                    <?php echo mb_strtolower($Morphy->castFormByGramInfo(mb_strtoupper($Functions["participant"]["Value"]), null, ['РД', 'ЕД'], TRUE)[0]) ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="mdl-card__title">
                        <div class="card_field">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"
                                 id="participants_editing_surname_input">
                                <input class="mdl-textfield__input" type="text" id="participants_editing_name">
                                <label class="mdl-textfield__label" for="participants_editing_name">Имя
                                    <?php echo mb_strtolower($Morphy->castFormByGramInfo(mb_strtoupper($Functions["participant"]["Value"]), null, ['РД', 'ЕД'], TRUE)[0]) ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="mdl-card__title">
                        <div class="card_field">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"
                                 id="participants_editing_middlename_input">
                                <input class="mdl-textfield__input" type="text" id="participants_editing_middlename">
                                <label class="mdl-textfield__label" for="participants_editing_middlename">Отчество
                                    <?php echo mb_strtolower($Morphy->castFormByGramInfo(mb_strtoupper($Functions["participant"]["Value"]), null, ['РД', 'ЕД'], TRUE)[0]) ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="mdl-card__title">
                        <div class="card_field">
                            <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect"
                                   for="participants_editing_sex-male">
                                <input type="radio" id="participants_editing_sex-male" class="mdl-radio__button"
                                       name="participants_editing_sex" value="мужской" checked>
                                <span class="mdl-radio__label">Мужской</span>
                            </label>
                            <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect"
                                   for="erticipants_editing_sex-female">
                                <input type="radio" id="participants_editing_sex-female" class="mdl-radio__button"
                                       name="participants_editing_sex" value="женский">
                                <span class="mdl-radio__label">Женский</span>
                            </label>
                        </div>
                    </div>
                    <div class="mdl-card__title mdl-card--border">
                        <div class="mdl-selectfield mdl-js-selectfield">
                            <select id="participants_editing_team" name="participants_edit_team" class="mdl-selectfield__select">
                                <?php
                                for($i = 0; $i < count($Teams); $i++){
                                    echo "<option value='".$Teams[$i]["Name"]."'>".$Teams[$i]["Name"]."</option>";
                                }
                                ?>
                            </select>
                            <label class="mdl-selectfield__label" for="participants_editing_team"><?php echo $Functions["team"]["Value"]?></label>
                        </div>
                    </div>
                    <div class="mdl-card__actions mdl-card--border">
                        <button class="mdl-button mdl-button--colored mdl-button--primary mdl-js-button mdl-js-ripple-effect on_edit-card-confirm-effect"
                                id="participants_editing-confirm">
                            сохранить
                        </button>
                        <button class="mdl-button mdl-button--colored mdl-button--accent mdl-js-button mdl-js-ripple-effect on_edit-card-cancel-effect"
                                id="participants_editing-cancel">
                            отмена
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="on_edit mdl-grid" id="employees_editing">
        <div class="on_edit-click"></div>
        <div class="mdl-grid mdl-cell mdl-cell-middle mdl-cell--12-col">
            <div class="mdl-cell mdl-cell--middle mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--4-col-desktop mdl-cell--4-offset-desktop">
                <div class="mdl-card mdl-shadow--6dp on_edit-card">
                    <div class="mdl-card__title mdl-card--border">
                        <div class="mdl-card__title-text" style="text-transform: none">Изменение данных сотрудника</div>
                    </div>
                    <div class="mdl-card__title">
                        <div class="card_field">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-upgraded"
                                 id="employees_editing_name_input">
                                <input class="mdl-textfield__input" type="text" id="employees_editing_surname">
                                <label class="mdl-textfield__label" for="employees_editing_surname">Фамилия
                                    сотрудника</label>
                            </div>
                        </div>
                    </div>
                    <div class="mdl-card__title">
                        <div class="card_field">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-upgraded"
                                 id="employees_editing_surname_input">
                                <input class="mdl-textfield__input" type="text" id="employees_editing_name">
                                <label class="mdl-textfield__label" for="employees_editing_name">Имя
                                    сотрудника</label>
                            </div>
                        </div>
                    </div>
                    <div class="mdl-card__title">
                        <div class="card_field">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-upgraded"
                                 id="employees_editing_middlename_input">
                                <input class="mdl-textfield__input" type="text" id="employees_editing_middlename">
                                <label class="mdl-textfield__label" for="employees_editing_middlename">Отчество
                                    сотрудника</label>
                            </div>
                        </div>
                    </div>
                    <div class="mdl-card__title">
                        <div class="card_field">
                            <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="employee_editing_sex-male">
                                <input type="radio" id="employee_editing_sex-male" class="mdl-radio__button"
                                       name="employees_editing_sex" value="мужской" checked>
                                <span class="mdl-radio__label">Мужской</span>
                            </label>
                            <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect"
                                   for="employee_editing_sex-female">
                                <input type="radio" id="employee_editing_sex-female" class="mdl-radio__button"
                                       name="employees_editing_sex" value="женский">
                                <span class="mdl-radio__label">Женский</span>
                            </label>
                        </div>
                    </div>
                    <div class="mdl-card__title">
                        <div class="card_field">
                            <div class="mdl-selectfield mdl-js-selectfield">
                                <select id="employees_editing_team" name="employees_editing_team" class="mdl-selectfield__select">
                                    <option value="не указан">Не указан</option>
                                    <?php
                                    for($i = 0; $i < count($Teams); $i++){
                                        echo "<option value='".$Teams[$i]["Name"]."'>".$Teams[$i]["Name"]."</option>";
                                    }
                                    ?>
                                </select>
                                <label class="mdl-selectfield__label" for="employees_editing_team"><?php echo $Functions["team"]["Value"]?></label>
                            </div>
                        </div>
                    </div>
                    <div class="mdl-card__title mdl-card--border">
                        <div class="card_field">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-upgraded"
                                 id="employees_editing_post_input">
                                <input class="mdl-textfield__input" type="text" id="employees_editing_post">
                                <label class="mdl-textfield__label" for="employees_editing_post">Должность
                                    сотрудника</label>
                            </div>
                        </div>
                    </div>
                    <div class="mdl-card__actions mdl-card--border">
                        <button class="mdl-button mdl-button--colored mdl-button--primary mdl-js-button mdl-js-ripple-effect on_edit-card-confirm-effect"
                                id="employees_editing-confirm">
                            сохранить
                        </button>
                        <button class="mdl-button mdl-button--colored mdl-button--accent mdl-js-button mdl-js-ripple-effect on_edit-card-cancel-effect"
                                id="employees_editing-cancel">
                            отмена
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="on_edit mdl-grid" id="team_adding">
        <div class="on_edit-click"></div>
        <div class="mdl-grid mdl-cell mdl-cell-middle mdl-cell--12-col">
            <div class="mdl-cell mdl-cell--middle mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--4-col-desktop mdl-cell--4-offset-desktop">
                <div class="mdl-card mdl-shadow--6dp on_edit-card">
                    <div class="mdl-card__title mdl-card--border">
                        <div class="mdl-card__title-text" style="text-transform: none">
                            Название <?php echo mb_strtolower($Morphy->castFormByGramInfo(mb_strtoupper($Functions["team"]["Value"]), null, ['ЕД', 'РД'], TRUE)[0]) ?></div>
                    </div>
                    <div class="mdl-card__title">
                        <div class="card_field">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"
                                 id="team_adding_input">
                                <input class="mdl-textfield__input" type="text" id="team_adding_name">
                                <label class="mdl-textfield__label" for="team_adding_name">Введите
                                    название <?php echo mb_strtolower($Morphy->castFormByGramInfo(mb_strtoupper($Functions["team"]["Value"]), null, ['ЕД', 'РД'], TRUE)[0]) ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="mdl-card__actions mdl-card--border">
                        <button class="mdl-button mdl-button--colored mdl-button--primary mdl-js-button mdl-js-ripple-effect on_edit-card-confirm"
                                id="team_adding-confirm">
                            сохранить
                        </button>
                        <button class="mdl-button mdl-button--colored mdl-button--accent mdl-js-button mdl-js-ripple-effect on_edit-card-cancel"
                                id="team_adding-cancel">
                            отмена
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="on_edit mdl-grid" id="team_editing">
        <div class="on_edit-click"></div>
        <div class="mdl-grid mdl-cell mdl-cell-middle mdl-cell--12-col">
            <div class="mdl-cell mdl-cell--middle mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--4-col-desktop mdl-cell--4-offset-desktop">
                <div class="mdl-card mdl-shadow--6dp on_edit-card">
                    <div class="mdl-card__title mdl-card--border">
                        <div class="mdl-card__title-text" style="text-transform: none">
                            Название <?php echo mb_strtolower($Morphy->castFormByGramInfo(mb_strtoupper($Functions["team"]["Value"]), null, ['ЕД', 'РД'], TRUE)[0]) ?></div>
                    </div>
                    <div class="mdl-card__title">
                        <div class="card_field">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"
                                 id="team_editing_input">
                                <input class="mdl-textfield__input" type="text" id="team_editing_name">
                                <label class="mdl-textfield__label" for="team_editing_name">Введите новое
                                    название <?php echo mb_strtolower($Morphy->castFormByGramInfo(mb_strtoupper($Functions["team"]["Value"]), null, ['ЕД', 'РД'], TRUE)[0]) ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="mdl-card__actions mdl-card--border">
                        <button class="mdl-button mdl-button--colored mdl-button--primary mdl-js-button mdl-js-ripple-effect on_edit-card-confirm"
                                id="team_editing-confirm">
                            сохранить
                        </button>
                        <button class="mdl-button mdl-button--colored mdl-button--accent mdl-js-button mdl-js-ripple-effect on_edit-card-cancel"
                                id="team_editing-cancel">
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
                <span class="mdl-layout-title"><?php echo $RequestData['organization'] ?></span></div>
            <div class="mdl-layout__tab-bar mdl-js-ripple-effect">
                <a href="#orgset_main" class="mdl-layout__tab is-active">Основные настройки</a>
                <a href="#orgset_teams"
                   class="mdl-layout__tab"><?php echo mb_strtolower($Morphy->castFormByGramInfo(mb_strtoupper($Functions["team"]["Value"]), null, ['МН', 'ИМ'], TRUE)[0]) ?></a>
                <a href="#orgset_participants"
                   class="mdl-layout__tab"><?php echo mb_strtolower($Morphy->castFormByGramInfo(mb_strtoupper($Functions["participant"]["Value"]), null, ['МН', 'ИМ'], TRUE)[0]) ?></a>
                <a href="#orgset_employees" class="mdl-layout__tab">Сотрудники</a>
                <a href="#orgset_achievements" class="mdl-layout__tab">Достижения</a>
                <a href="#orgset_actions" class="mdl-layout__tab">События</a>
                <a href="#orgset_help" class="mdl-layout__tab">Помощь</a>
            </div>
        </header>
        <div class="mdl-layout__drawer">
            <span class="mdl-layout-title">Управление</span>
            <nav class="mdl-navigation">
                <a class="mdl-navigation__link wave-effect" href="index.php">главная</a>
                <a class="mdl-navigation__link wave-effect" href="profile.php?login=<?php echo $Login ?>">профиль</a>
                <?php if ($RequestData["accesslevel"] === "admin" || "employee"): ?>
                    <a class="mdl-navigation__link wave-effect" href="categories.php">баллы</a>
                <?php endif ?>
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
                    <div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--5-col-desktop mdl-cell--1-offset-desktop">
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
                    <div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--5-col-desktop">
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
                    <div class="mdl-cell mdl-cell--1-col-desktop mdl-cell--hide-tablet mdl-cell--hide-phone"></div>
                    <!-- Next level -->
                    <div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--5-col-desktop mdl-cell--1-offset-desktop">
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
                    <div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--5-col-desktop">
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
                    <div class="mdl-cell mdl-cell--1-col-desktop mdl-cell--hide-tablet mdl-cell--hide-phone"></div>
                    <!-- Next level -->
                    <div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--5-col-desktop mdl-cell--1-offset-desktop">
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
                                echo "<div class='category-buttons'>";
                                echo "<button class='mdl-button mdl-js-button mdl-button--icon mdl-button--colored mdl-button--primary category-edit' id='category_edit-" . str_replace(' ', "_", $Categories[$i]["Key"]) . "'>";
                                echo "<i class='material-icons'>create</i></button>";
                                echo "<button class='mdl-button mdl-js-button mdl-button--icon mdl-button--colored mdl-button--accent category-delete' id='" . str_replace(' ', "_", $Categories[$i]["Value"]) . "'>";
                                echo "<i class='material-icons'>delete_forever</i></button>";
                                echo "</div></div>";
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
                    <div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--5-col-desktop">
                        <div class="mdl-card mdl-shadow--6dp" id="additional_settings">
                            <div class="mdl-card__title mdl-card--border">
                                <div class="mdl-card__title-text" style="text-transform: none">Доп. настройки</div>
                            </div>
                            <!-- Отрицательные оценки -->
                            <div class="mdl-card__title mdl-card--border">
                                <div class='card_field'>
                                    <i class='material-icons'>more_vert</i>
                                    <div class='card_field_text additional_settings_field' style="text-transform: none">
                                        Отрицательные оценки
                                    </div>
                                </div>
                                <label class='mdl-switch mdl-js-switch mdl-js-ripple-effect settings_switch'
                                       for='switch-abs'>
                                    <input type='checkbox' id='switch-abs'
                                           class='mdl-switch__input additional_settings_switch'
                                        <?php
                                        if ($Functions["abs"]["Value"] == 1) {
                                            echo "checked";
                                        }
                                        ?>
                                    >
                                    <span class='mdl-switch__label'></span>
                                </label>
                            </div>
                            <!-- Могут ли сотрудники выставлять баллы своей команде -->
                            <div class="mdl-card__title mdl-card--border">
                                <div class='card_field'>
                                    <i class='material-icons'>more_vert</i>
                                    <div class='card_field_text additional_settings_field' style="text-transform: none">
                                        Оценки своей команде
                                    </div>
                                </div>
                                <label class='mdl-switch mdl-js-switch mdl-js-ripple-effect settings_switch'
                                       for='switch-team_leader'>
                                    <input type='checkbox' id='switch-team_leader'
                                           class='mdl-switch__input additional_settings_switch'
                                        <?php
                                        if ($Functions["team_leader"]["Value"] == 1) {
                                            echo "checked";
                                        }
                                        ?>
                                    >
                                    <span class='mdl-switch__label'></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mdl-cell mdl-cell--1-col-desktop mdl-cell--hide-tablet mdl-cell--hide-phone"></div>
                </div>
            </section>
            <!-- Teams -->
            <section class="mdl-layout__tab-panel" id="orgset_teams">
                <div class="page-content mdl-grid">
                    <div class="mdl-cell mdl-cell--12-col">
                        <div class="mdl-card mdl-shadow--6dp">
                            <div class="mdl-card__title">
                                <div class="mdl-card__title-text"><?php echo mb_strtolower($Morphy->castFormByGramInfo(mb_strtoupper($Functions["team"]["Value"]), null, ['МН', 'ИМ'], TRUE)[0]) ?></div>
                            </div>
                            <div class="mdl-card__title" id="teams_card">
                                <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp"
                                       id="teams_card_table">
                                    <thead>
                                    <tr>
                                        <th class="mdl-data-table__cell--non-numeric">Название</th>
                                        <th class="mdl-data-table__cell--non-numeric">Руководитель</th>
                                        <th>
                                            Кол-во <?php echo mb_strtolower($Morphy->castFormByGramInfo(mb_strtoupper($Functions["participant"]["Value"]), null, ['МН', 'РД'], TRUE)[0]) ?></th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    for ($i = 0; $i < count($Teams); $i++) {
                                        echo "<tr><td class='mdl-data-table__cell--non-numeric'>";
                                        echo $Teams[$i]["Name"];
                                        echo "<td class='mdl-data-table__cell--non-numeric'>";
                                        if (isset($Teams[$i]["Head"])) {
                                            echo "<a href='profile.php?login=" . $Teams[$i]["Head"]["Login"] . "'>";
                                            echo $Teams[$i]["Head"]["Surname"] . " " . $Teams[$i]["Head"]["Name"] . " " . $Teams[$i]["Head"]["Middlename"];
                                            echo "</a></td>";
                                        } else {
                                            echo "не указан</td>";
                                        }
                                        echo "<td>" . $Teams[$i]["Value"] . "</td>";
                                        echo "<td><button class='mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-button--primary team_table_edit' id='team_edit-" . $Teams[$i]["Name"] . "'>
                                                <i class='material-icons'>create</i>
                                            </button>";
                                        echo "<button class='mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-button--accent team_table_delete' id='team_delete-" . $Teams[$i]["Name"] . "'>
                                                <i class='material-icons'>delete_forever</i>
                                            </button></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mdl-card__menu">
                                <button class="mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-button--colored mdl-button--primary"
                                        id="button_teams">
                                    <i class="material-icons">add</i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Participants -->
            <section class="mdl-layout__tab-panel" id="orgset_participants">
                <div class="page-content mdl-grid">
                    <div class="mdl-cell mdl-cell--12-col">
                        <div class="mdl-card mdl-shadow--6dp">
                            <div class="mdl-card__title">
                                <div class="mdl-card__title-text"><?php echo mb_strtolower($Morphy->castFormByGramInfo(mb_strtoupper($Functions["participant"]["Value"]), null, ['МН', 'ИМ'], TRUE)[0]) ?></div>
                            </div>
                            <div class="mdl-card__title" id="participants_card">
                                <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp"
                                       id="participants_card_table">
                                    <thead>
                                    <tr>
                                        <th class="mdl-data-table__cell--non-numeric">ФИО</th>
                                        <th class="mdl-data-table__cell--non-numeric">Пол</th>
                                        <th class="mdl-data-table__cell--non-numeric"
                                            style="text-transform: capitalize"><?php echo $Functions["team"]["Value"] ?></th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    for ($i = 0; $i < $Participants["val"]; $i++) {
                                        echo "<tr>";
                                        echo "<td class='mdl-data-table__cell--non-numeric' id='" . $Participants[$i]["Login"] . "'><a href='profile.php?login=" . $Participants[$i]["Login"] . "'>" . $Participants[$i]["surname"] . " " .
                                            $Participants[$i]["name"] . " " . $Participants[$i]["middlename"] . "</a></td>";
                                        echo "<td class='mdl-data-table__cell--non-numeric'>" . $Participants[$i]["sex"] . "</td>";
                                        echo "<td class='mdl-data-table__cell--non-numeric'>" . $Participants[$i]["team"] . "</td>";
                                        echo "<td><button class='mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-button--primary participants_table_edit'>
                                                <i class='material-icons'>create</i>
                                            </button>";
                                        echo "<button class='mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-button--accent participants_table_delete' id='employee_delete-" . $Participants[$i]["Login"] . "'>
                                                <i class='material-icons'>delete_forever</i>
                                            </button></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mdl-card__menu">
                                <button class="mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-button--colored mdl-button--primary"
                                        id="button_participants">
                                    <i class="material-icons">add</i>
                                </button>
                                <a href="media/basedata/<?php echo $Organization ?>_participants.xlsx">
                                    <button class="mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-button--colored mdl-button--primary">
                                        <i class="material-icons">cloud_download</i>
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Employees -->
            <section class="mdl-layout__tab-panel" id="orgset_employees">
                <div class="page-content mdl-grid">
                    <div class="mdl-cell mdl-cell--12-col">
                        <div class="mdl-card mdl-shadow--6dp">
                            <div class="mdl-card__title">
                                <div class="mdl-card__title-text" style="text-transform: none">Сотрудники</div>
                            </div>
                            <div class="mdl-card__title" id="employees_card">
                                <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp"
                                       id="employees_card_table">
                                    <thead>
                                    <tr>
                                        <th class="mdl-data-table__cell--non-numeric">ФИО</th>
                                        <th class="mdl-data-table__cell--non-numeric">Пол</th>
                                        <th class="mdl-data-table__cell--non-numeric">Должность</th>
                                        <th class="mdl-data-table__cell--non-numeric"
                                            style="text-transform: capitalize"><?php echo $Functions["team"]["Value"] ?></th>
                                        <?php
                                        for ($i = 0; $i < $Categories['val']; $i++) {
                                            echo "<th>" . $Categories[$i]["Value"] . "</th>";
                                        }
                                        ?>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    for ($i = 0; $i < $Employees["val"]; $i++) {
                                        echo "<tr>";
                                        echo "<td class='mdl-data-table__cell--non-numeric' id=" . $Employees[$i]["Login"] .
                                            "><a href='profile.php?login=" . $Employees[$i]["Login"] . "'>" . $Employees[$i]["surname"] . " " .
                                            $Employees[$i]["name"] . " " . $Employees[$i]["middlename"] . "</a></td>";
                                        echo "<td class='mdl-data-table__cell--non-numeric'>" . $Employees[$i]["sex"] . "</td>";
                                        echo "<td class='mdl-data-table__cell--non-numeric'>" . $Employees[$i]["Post"] . "</td>";
                                        echo "<td class='mdl-data-table__cell--non-numeric'>" . $Employees[$i]["team"] . "</td>";
                                        for ($c = 0; $c < $Categories['val']; $c++) {
                                            if ($Employees[$i][$Categories[$c]["Key"]] == 1) {
                                                echo "<td>" . "<label class='mdl-switch mdl-js-switch mdl-js-ripple-effect' for='switch-employee-" . $Employees[$i]["Login"] . "-" . $Categories[$c]['Key'] . "' >
                                                    <input type = 'checkbox' id = 'switch-employee-" . $Employees[$i]["Login"] . "-" . $Categories[$c]['Key'] . "' class='mdl-switch__input employee_category_switch' checked >
                                                    <span class='mdl-switch__label' ></span >
                                                </label >" . "</td>";
                                            } else {
                                                echo "<td>" . "<label class='mdl-switch mdl-js-switch mdl-js-ripple-effect' for='switch-employee-" . $Employees[$i]["Login"] . "-" . $Categories[$c]['Key'] . "' >
                                                    <input type = 'checkbox' id = 'switch-employee-" . $Employees[$i]["Login"] . "-" . $Categories[$c]['Key'] . "' class='mdl-switch__input employee_category_switch' >
                                                    <span class='mdl-switch__label' ></span >
                                                </label >" . "</td>";
                                            }
                                        }
                                        echo "<td><button class='mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-button--primary employees_table_edit'>
                                                <i class='material-icons'>create</i>
                                            </button>";
                                        echo "<button class='mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-button--accent employees_table_delete' id='employee_delete-" . $Employees[$i]["Login"] . "'>
                                                <i class='material-icons'>delete_forever</i>
                                            </button></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mdl-card__menu">
                                <button class="mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-button--colored mdl-button--primary"
                                        id="button_employees">
                                    <i class="material-icons">add</i>
                                </button>
                                <a href="media/basedata/<?php echo $Organization ?>_employees.xlsx">
                                    <button class="mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-button--colored mdl-button--primary">
                                        <i class="material-icons">cloud_download</i>
                                    </button>
                                </a>
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
                    <div class="mdl-cell mdl-cell--12-col">
                        <div class="mdl-card mdl-shadow--6dp">
                            <div class="mdl-card__title mdl-card--border">
                                <div class="mdl-card__title-text" style="text-transform: none">События</div>
                            </div>
                            <div class="mdl-card__title" id="actions_card">
                                <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp"
                                       id="actions_card_table">
                                    <thead>
                                    <tr>
                                        <th class="mdl-data-table__cell--non-numeric">Событие</th>
                                        <th class="mdl-data-table__cell--non-numeric">Дата</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    for ($i = 0; $i < count($Actions); $i++) {
                                        echo "<tr>";
                                        switch ($Actions[$i]["Type"]) {
                                            case "mark":
                                                echo "<td class='mdl-data-table__cell--non-numeric'><a href='profile.php?login=" . $Actions[$i]["Subject"] . "'>" . $Actions[$i]["Subject"] . "</a> ";
                                                echo "изменил балл в категории '" . $Categories[explode("Cat", $Actions[$i]["Options"]["categoryID"])[1]]["Value"] . "' ";
                                                echo mb_strtolower($Morphy->castFormByGramInfo(mb_strtoupper($Functions["participant"]["Value"]), null, ['ЕД', 'МР', 'ДТ'], TRUE)[0]);
                                                echo " <a href='profile.php?login=" . $Actions[$i]["Object"] . "'>" . $Actions[$i]["Object"] . "</a> ";
                                                echo "на '" . $Actions[$i]["Options"]["change"] . "' ";
                                                echo "по причине '" . $Actions[$i]["Options"]["reason"] . "'";
                                                echo "</td>";
                                                echo "<td class='mdl-data-table__cell--non-numeric'>";
                                                echo substr($Actions[$i]["Time"], 0, 10);
                                                echo "</td>";
                                                break;
                                            default:
                                                break;
                                        }
                                        echo "</tr>";
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Help -->
            <section class="mdl-layout__tab-panel" id="orgset_help">
            </section>
        </main>
    </div>
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <!-- MDL -->
    <script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
    <script src="scripts/js/mdl-selectfield.js"></script>
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
