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

var re = new RegExp("^[а-яА-ЯёЁa-zA-Z0-9\\s]+$");

var Token = $.cookie("sid");

function OrganizationNameEdit(OrgName){
    $.post("../../requests/changeorganizationname.php", {token: Token, orgname: OrgName}, function (Resp) {
       if(Resp["code"] === 200){
           $('#organization_name').text(OrgName);
           notie.alert(1, "Название организации успешно изменено!", 3);
       } else {
           notie.alert(3, "Ошибка!", 3);
       }
       preloader.off();
    }, "json");
}

function PeriodNameEdit(PerName){
    $.post("../../requests/changeperiodname.php", {token: Token, pername: PerName}, function (Resp) {
        if(Resp["code"] === 200){
            $('#period_field').text(PerName);
            notie.alert(1, "Название периода успешно изменено!", 3);
        } else {
            notie.alert(3, "Ошибка!", 3);
        }
        preloader.off();
    }, "json");
}

function ParticipantNameEdit(ParName){
    $.post("../../requests/changeparticipantname.php", {token: Token, partname: ParName}, function (Resp) {
        if(Resp["code"] === 200){
            $('#participant_field').text(ParName);
            notie.alert(1, "Название участника успешно изменено!", 3);
        } else {
            notie.alert(3, "Ошибка!", 3);
        }
        preloader.off();
    }, "json");
}

function TeamNameEdit(TeamName){
    $.post("../../requests/changeteamname.php", {token: Token, teamname: TeamName}, function (Resp) {
        if(Resp["code"] === 200){
            $('#team_field').text(TeamName)
            notie.alert(1, "Название команд успешно изменено!", 3);
        } else {
            notie.alert(3, "Ошибка!", 3);
        }
        preloader.off();
    }, "json");
}

function ActivateEditMode(Obj) {
    var ID = GetIdFromObject(Obj);
    $('#'+ID+'_edit').fadeIn().css("display", "flex");
}

function Fade_Out_Edit() {
    $('.on_edit').fadeOut();
}

function Cancel_Edit(Obj) {
    $('.on_edit').fadeOut();
    var ID = GetIdFromObject(Obj);
    $('#'+ID).val('');
}

function Confirm_Edit(Obj) {
    preloader.on();
    var ID = GetIdFromObject(Obj);
    switch (ID){
        case "organization_name":
            var OrgName = $('#'+ID).val();
            if(CheckInputData(OrgName, ID)) {
                OrganizationNameEdit(OrgName);
            }
            break;
        case "period_name":
            var PerName = $('#'+ID).val();
            if(CheckInputData(PerName, ID)) {
                PeriodNameEdit(PerName);
            }
            break;
        case "participant_name":
            var ParName = $('#'+ID).val();
            if(CheckInputData(ParName, ID)) {
                ParticipantNameEdit(ParName);
            }
            break;
        case "team_name":
            var TeamName = $('#'+ID).val();
            if(CheckInputData(TeamName, ID)) {
                TeamNameEdit(TeamName);
            }
            break;
        default:
            break;
    }
}

function CheckInputData(Data, ID) {
    if(Data.length > 0){
        if(re.test(Data)){
            $('.on_edit').fadeOut();
            $('#'+ID).val('');
            return true;
        } else {
            notie.alert(3, "Данные не могут содержать спецсимволов!", 3);
            $('#'+ID+'_input').addClass("is-invalid");
            preloader.off();
            return false;
        }
    } else {
        notie.alert(3, "Не все поля заполнены!", 3);
        $('#'+ID+'_input').addClass("is-invalid");
        preloader.off();
        return false;
    }
}

function GetIdFromObject(Obj){
    var ID = Obj["delegateTarget"]["id"];
    ID = ID.split("_");
    ID = ID[0]+"_"+ID[1];
    return ID;
}

jQuery('document').ready(function () {
    $('.on_edit-activation').click(ActivateEditMode);
    $('.on_edit-click').click(Fade_Out_Edit);
    $('.on_edit-card-cancel').click(Cancel_Edit);
    $('.on_edit-card-confirm').click(Confirm_Edit);
    $('#on_edit-organization_name_edit').click(ActivateEditMode);
});