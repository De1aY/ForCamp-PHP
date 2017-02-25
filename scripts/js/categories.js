var preloader = new $.materialPreloader({
    position: 'top',
    height: '5px',
    col_1: '#159756',
    col_2: '#da4733',
    col_3: '#3b78e7',
    col_4: '#fdba2c',
    fadeIn: 200,
    fadeOut: 200
});

var reNum = new RegExp("^[0-9\-\+]+$");
var reGeneral = new RegExp("^[а-яА-ЯёЁa-zA-Z0-9\\s\"\-]+$");

var Token = $.cookie("sid");
var CurrentUserID = null;
var CurrentCategory = null;

function Fade_Out_Edit() {
    $('.on_edit').fadeOut();
}

function CheckInputDataNum(Data, ID, AutoFadeOut) {
    if (Data.length > 0) {
        if (reNum.test(Data)) {
            if (AutoFadeOut) {
                $('.on_edit').fadeOut();
                $('#' + ID).val('');
            }
            return true;
        } else {
            notie.alert(3, "Данные могут содержать только цифры и знаки '+' или '-'", 3);
            $('#' + ID + '_input').addClass("is-invalid");
            preloader.off();
            return false;
        }
    } else {
        notie.alert(3, "Не все поля заполнены!", 3);
        $('#' + ID + '_input').addClass("is-invalid");
        preloader.off();
        return false;
    }
}

function CheckInputDataGeneral(Data, ID, AutoFadeOut) {
    if (Data.length > 0) {
        if (reGeneral.test(Data)) {
            if (AutoFadeOut) {
                $('.on_edit').fadeOut();
                $('#' + ID).val('');
            }
            return true;
        } else {
            notie.alert(3, "Данные не могут содержать спецсимволов(кроме \" и - )!", 3);
            $('#' + ID + '_input').addClass("is-invalid");
            preloader.off();
            return false;
        }
    } else {
        notie.alert(3, "Не все поля заполнены!", 3);
        $('#' + ID + '_input').addClass("is-invalid");
        preloader.off();
        return false;
    }
}

function ChangeMark() {
    var Element = $(this);
    var Data = Element[0]["id"].substr(17);
    Data = Data.split("-");
    CurrentUserID = Data[0];
    CurrentCategory = Data[1];
    var Title = $('#participants_card_table').children('thead').children("tr").children("th:eq("+Element[0]["cellIndex"]+")");
    $('#participant_mark_edit_title').text("Изменение баллов "+"\'"+Title[0]["innerText"]+"\'");
    if(Element.attr('team_disabled') != undefined) {
        notie.alert(3, "Вы не можете редактировать баллы этого участника!", 3);
    } else {
        if (Element.attr('disabled') === "disabled") {
            notie.alert(3, "Вы не можете редактировать данную категорию!", 3);
        } else {
            $('#participant_mark_edit').fadeIn().css("display", "flex");
        }
    }
}

function CheckData(Mark, Reason) {
    var Result = true;
    if (!CheckInputDataNum(Mark, "participant_mark", false)){
        Result = false;
    }
    if (!CheckInputDataGeneral(Reason, "participant_reason", false)){
        Result = false;
    }
    return Result;
}

function ChangeMarkConfirm() {
    preloader.on();
    var Mark = $('#participant_mark').val();
    var Reason = $('#participant_reason').val();
    if(CheckData(Mark, Reason)){
        $.post('../../requests/editmark.php', {token: Token, userID: CurrentUserID, categoryID: CurrentCategory, reason: Reason, change: Mark}, function (data) {
            if (data["code"] === 200) {
                notie.alert(1, "Балл успешно изменён!", 3);
                setTimeout('window.location.reload(true)', 1000);
            } else {
                notie.alert(3, "Произошла ошибка("+data["code"]+")!", 3);
                setTimeout('window.location.reload(true)', 1000);
            }
            preloader.off();
        }, "json");
    }
}

$(document).ready(function () {
    $('.on_edit-click').click(Fade_Out_Edit);
    $('#participants_card_table').ReStable({
        keepHtml: true,
        rowHeaders: false,
        maxWidth: 810
    });
    $('.participant_mark').click(ChangeMark);
    $('#participant_mark_edit-cancel').click(function () {
       $('.on_edit').fadeOut();
       $('#participant_mark').val("");
       $('#participant_reason').val("");
    });
    $('#participant_mark_edit-confirm').click(ChangeMarkConfirm);
});