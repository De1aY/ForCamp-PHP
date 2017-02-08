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

/* General */
function Fade_Out_Edit() {
    $('.on_edit').fadeOut();
}

function CheckInputData(Data, ID) {
    if (Data.length > 0) {
        if (re.test(Data)) {
            $('.on_edit').fadeOut();
            $('#' + ID).val('');
            return true;
        } else {
            notie.alert(3, "Данные не могут содержать спецсимволов!", 3);
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
/*----------------*/

/* Main functions */
function OrganizationNameEdit(OrgName) {
    $.post("../../requests/changeorganizationname.php", {token: Token, orgname: OrgName}, function (Resp) {
        if (Resp["code"] === 200) {
            $('#organization_field').text(OrgName);
            notie.alert(1, "Название организации успешно изменено!", 3);
        } else {
            notie.alert(3, "Произошла ошибка!", 3);
        }
        preloader.off();
    }, "json");
}

function PeriodNameEdit(PerName) {
    $.post("../../requests/changeperiodname.php", {token: Token, pername: PerName}, function (Resp) {
        if (Resp["code"] === 200) {
            $('#period_field').text(PerName);
            notie.alert(1, "Название периода успешно изменено!", 3);
        } else {
            notie.alert(3, "Произошла ошибка!", 3);
        }
        preloader.off();
    }, "json");
}

function ParticipantNameEdit(ParName) {
    $.post("../../requests/changeparticipantname.php", {token: Token, partname: ParName}, function (Resp) {
        if (Resp["code"] === 200) {
            $('#participant_field').text(ParName);
            notie.alert(1, "Название участника успешно изменено!", 3);
        } else {
            notie.alert(3, "Произошла ошибка!", 3);
        }
        preloader.off();
    }, "json");
}

function TeamNameEdit(TeamName) {
    $.post("../../requests/changeteamname.php", {token: Token, teamname: TeamName}, function (Resp) {
        if (Resp["code"] === 200) {
            $('#team_field').text(TeamName)
            notie.alert(1, "Название команд успешно изменено!", 3);
        } else {
            notie.alert(3, "Произошла ошибка!", 3);
        }
        preloader.off();
    }, "json");
}

function ActivateEditMode(Obj) {
    var ID = GetIdFromObject(Obj);
    $('#' + ID + '_edit').fadeIn().css("display", "flex");
}

function Cancel_Edit(Obj) {
    $('.on_edit').fadeOut();
    var ID = GetIdFromObject(Obj);
    $('#' + ID).val('');
}

function Confirm_Edit(Obj) {
    preloader.on();
    var ID = GetIdFromObject(Obj);
    switch (ID) {
        case "organization_name":
            var OrgName = $('#' + ID).val();
            if (CheckInputData(OrgName, ID)) {
                OrganizationNameEdit(OrgName);
            }
            break;
        case "period_name":
            var PerName = $('#' + ID).val();
            if (CheckInputData(PerName, ID)) {
                PeriodNameEdit(PerName);
            }
            break;
        case "participant_name":
            var ParName = $('#' + ID).val();
            if (CheckInputData(ParName, ID)) {
                ParticipantNameEdit(ParName);
            }
            break;
        case "team_name":
            var TeamName = $('#' + ID).val();
            if (CheckInputData(TeamName, ID)) {
                TeamNameEdit(TeamName);
            }
            break;
        default:
            break;
    }
}

function GetIdFromObject(Obj) {
    var ID = Obj["delegateTarget"]["id"];
    ID = ID.split("_");
    ID = ID[0] + "_" + ID[1];
    return ID;
}
/*----------------*/

/* Categories */
function AddCategory(Category) {
    $('#categories_list').append("<div class='mdl-card__title mdl-card--border' id='" + Category + "_row'>" +
        "<div class='card_field'>" +
        "<i class='material-icons'>more_vert</i>" +
        "<div class='card_field_text category_name'>" + Category + "</div>" +
        "</div>" +
        "<button class='mdl-button mdl-js-button mdl-button--icon mdl-button--colored mdl-button--accent category-delete' id='" + Category + "'>" +
        "<i class='material-icons'>clear</i></button>" +
        "</div>");
    $('.category-delete').click(DeleteCategory);
    EditCategories();
}

function CategoryAdding() {
    $('#categories_adding').fadeIn().css("display", "flex");
}

function ConfirmCategoryAdding() {
    preloader.on();
    var Category = $('#categories').val();
    if (CheckInputData(Category, "categories")) {
        AddCategory(Category);
    }
}

function CancelCategoryAdding() {
    $('#categories_adding').fadeOut();
    $('#categories').val('');
}

function DeleteCategory(Obj) {
    preloader.on();
    var ID = Obj["delegateTarget"]["id"];
    $('#' + ID + "_row").remove();
    EditCategories();
}

function EditCategories() {
    var Req = [];
    var Categories = $('.category_name');
    for (i = 0; i < Categories.length; i++) {
        Req[i] = $(Categories[i]).text();
    }
    $.post("../../requests/editcategories.php", {token: Token, categories: JSON.stringify(Req)}, function (data) {
        if (data["code"] === 200) {
            notie.alert(1, "Категории успешно изменены!", 3);
            preloader.off();
        } else {
            notie.alert(3, "Произошла ошибка!", 3);
            preloader.off();
        }
    }, "json");
}
/*----------------*/

/* Participants */
function ParticipantsAdding() {
    $('#participants_adding').fadeIn().css("display", "flex");
}

function PartitcipantsAddingFile() {
    $('#participants_adding').fadeOut(400, function () {
        $('#participants_adding_file').fadeIn().css("display", "flex");
    });
}

function CancelParticipantsAdding() {
    $('#participants_adding').fadeOut();
    $('#participants_adding_name').val('');
    $('#participants_adding_surname').val('');
    $('#participants_adding_middlename').val('');
    $('#participants_adding_sex').val('');
    $('#participants_adding_team').val('');
}
/*----------------*/

jQuery('document').ready(function () {
    $('.on_edit-activation').click(ActivateEditMode);
    $('.on_edit-click').click(Fade_Out_Edit);
    $('.on_edit-card-cancel').click(Cancel_Edit);
    $('.on_edit-card-confirm').click(Confirm_Edit);
    $('#on_edit-organization_name_edit').click(ActivateEditMode);
    $('#categories-add').click(CategoryAdding);
    $('#categories_adding-confirm').click(ConfirmCategoryAdding);
    $('#categories_adding-cancel').click(CancelCategoryAdding);
    $('.category-delete').click(DeleteCategory);
    $('#button_participants').click(ParticipantsAdding);
    $('#participants_adding-file').click(PartitcipantsAddingFile);
    $('#button_participants_file').click(function () {
        window.location.href = "media/examples/example.xlsx";
    });
    $('#participants_adding-cancel').click(CancelParticipantsAdding);
    $('#participants_card_table').ReStable({
        keepHtml : true,
        rowHeaders : false,
        maxWidth: 810
    });
});