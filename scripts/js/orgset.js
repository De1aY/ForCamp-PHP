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
var CurrentUserID = null;
var CurrentCategory = null;
var CurrentTeamName = null;

/* General */
function Fade_Out_Edit() {
    $('.on_edit').fadeOut();
}

function CheckInputData(Data, ID, AutoFadeOut) {
    if (Data.length > 0) {
        if (re.test(Data)) {
            if (AutoFadeOut) {
                $('.on_edit').fadeOut();
                $('#' + ID).val('');
            }
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
            setTimeout('window.location.reload(true)', 1000);
        } else {
            notie.alert(3, "Произошла ошибка("+data["code"]+")!", 3);
            setTimeout('window.location.reload(true)', 1000);
        }
        preloader.off();
    }, "json");
}

function PeriodNameEdit(PerName) {
    $.post("../../requests/changeperiodname.php", {token: Token, pername: PerName}, function (Resp) {
        if (Resp["code"] === 200) {
            $('#period_field').text(PerName);
            notie.alert(1, "Название периода успешно изменено!", 3);
            setTimeout('window.location.reload(true)', 1000);
        } else {
            notie.alert(3, "Произошла ошибка("+data["code"]+")!", 3);
            setTimeout('window.location.reload(true)', 1000);
        }
        preloader.off();
    }, "json");
}

function ParticipantNameEdit(ParName) {
    $.post("../../requests/changeparticipantname.php", {token: Token, partname: ParName}, function (Resp) {
        if (Resp["code"] === 200) {
            $('#participant_field').text(ParName);
            notie.alert(1, "Название участника успешно изменено!", 3);
            setTimeout('window.location.reload(true)', 1000);
        } else {
            notie.alert(3, "Произошла ошибка("+data["code"]+")!", 3);
            setTimeout('window.location.reload(true)', 1000);
        }
        preloader.off();
    }, "json");
}

function TeamNameEdit(TeamName) {
    $.post("../../requests/changeteamname.php", {token: Token, teamname: TeamName}, function (Resp) {
        if (Resp["code"] === 200) {
            $('#team_field').text(TeamName)
            notie.alert(1, "Название команд успешно изменено!", 3);
            setTimeout('window.location.reload(true)', 1000);
        } else {
            notie.alert(3, "Произошла ошибка("+data["code"]+")!", 3);
            setTimeout('window.location.reload(true)', 1000);
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
            if (CheckInputData(OrgName, ID, true)) {
                OrganizationNameEdit(OrgName);
            }
            break;
        case "period_name":
            var PerName = $('#' + ID).val();
            if (CheckInputData(PerName, ID, true)) {
                PeriodNameEdit(PerName);
            }
            break;
        case "participant_name":
            var ParName = $('#' + ID).val();
            if (CheckInputData(ParName, ID, true)) {
                ParticipantNameEdit(ParName);
            }
            break;
        case "team_name":
            var TeamName = $('#' + ID).val();
            if (CheckInputData(TeamName, ID, true)) {
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
function CategoryAdding() {
    $('#categories_adding').fadeIn().css("display", "flex");
}

function AddCategory(Category) {
    $('#categories_list').append("<div class='mdl-card__title mdl-card--border' id='" + Category + "_row'>" +
        "<div class='card_field'>" +
        "<i class='material-icons'>more_vert</i>" +
        "<div class='card_field_text category_name'>" + Category + "</div>" +
        "</div><div class='category-buttons'>" +
        "<button class='mdl-button mdl-js-button mdl-button--icon mdl-button--colored mdl-button--primary category-delete' id='" + Category + "'>" +
        "<i class='material-icons'>create</i></button>" +
        "<button class='mdl-button mdl-js-button mdl-button--icon mdl-button--colored mdl-button--accent category-delete' id='" + Category + "'>" +
        "<i class='material-icons'>delete_forever</i></button>" +
        "</div></div>");
    $('.category-delete').click(DeleteCategory);
    EditCategories();
}

function ConfirmCategoryAdding() {
    preloader.on();
    var Category = $('#categories').val();
    if (CheckInputData(Category, "categories", true)) {
        AddCategory(Category)
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
            setTimeout('window.location.reload(true)', 1000);
            preloader.off();
        } else {
            notie.alert(3, "Произошла ошибка("+data["code"]+")!", 3);
            setTimeout('window.location.reload(true)', 1000);
            preloader.off();
        }
    }, "json");
}

function EditCategoryName_Start(obj) {
    $('#categories_editing').fadeIn().css("display", "flex");
    CurrentCategory = obj["currentTarget"]["id"].substr(14);
}

function EditCategoryName_Confirm() {
    $('.on_edit').fadeOut();
    preloader.on();
    var Category = $('#categories-editing').val();
    if(CheckInputData(Category, "category_editing", false)){
        EditCategoryName_Request(Category);
        $('#categories-editing').val("");
    }
}

function EditCategoryName_Request(catName) {
    $.post("../../requests/editcategoryname.php", {
        token: Token,
        categoryName: catName,
        categoryID: CurrentCategory
    }, function (data) {
        if (data["code"] === 200) {
            notie.alert(1, "Данные успешно изменены!", 3);
            setTimeout('window.location.reload(true)', 1000);
        } else {
            notie.alert(3, "Произошла ошибка("+data["code"]+")!", 3);
            setTimeout('window.location.reload(true)', 1000);
        }
        preloader.off();
    }, "json");
}

function EditCategoryName_Cancel() {
    $('#categories-editing').val("");
    $('.on_edit').fadeOut();
}
/*----------------*/

/* Participants */
function ParticipantsAdding() {
    $('#participants_adding').fadeIn().css("display", "flex");
}

function ParticipantsAddingConfirm() {
    preloader.on();
    ParName = $('#participants_adding_name').val();
    ParSurname = $('#participants_adding_surname').val();
    ParMiddlename = $('#participants_adding_middlename').val();
    ParSex = $("input[name='participants_adding_sex']:checked").val();
    ParTeam = $('#participants_adding_team').val();
    if (CheckParticipantFields(ParName, ParSurname, ParMiddlename, ParTeam)) {
        $('.on_edit').fadeOut();
        AddParticipant(ParName, ParSurname, ParMiddlename, ParSex, ParTeam);
    }
}

function AddParticipant(ParName, ParSurname, ParMiddlename, ParSex, ParTeam) {
    $.post("../../requests/addparticipant.php", {
        token: Token,
        name: ParName,
        surname: ParSurname,
        middlename: ParMiddlename,
        sex: ParSex,
        team: ParTeam
    }, function (data) {
        if (data["code"] === 200) {
            notie.alert(1, "Участник успешно добавлен!", 3);
            setTimeout('window.location.reload(true)', 1000);
        } else {
            notie.alert(3, "Произошла ошибка("+data["code"]+")!", 3);
            setTimeout('window.location.reload(true)', 1000);
        }
        preloader.off();
    }, "json");
}

function CheckParticipantFields(ParName, ParSurname, ParMiddlename, ParTeam) {
    var Result = true;
    if (!CheckInputData(ParTeam, "participants_adding_team", false)) {
        Result = false;
    }
    if (!CheckInputData(ParName, "participants_adding_name", false)) {
        Result = false;
    }
    if (!CheckInputData(ParSurname, "participants_adding_surname", false)) {
        Result = false;
    }
    if (!CheckInputData(ParMiddlename, "participants_adding_middlename", false)) {
        Result = false;
    }
    return Result
}

function DeleteParticipant(obj) {
    preloader.on();
    var ID = obj["currentTarget"]["id"].substr(16);
    $.post("../../requests/deleteparticipant.php", {token: Token, userID: ID}, function (data) {
        if (data["code"] === 200) {
            notie.alert(1, "Участник успешно удалён!", 3);
            setTimeout('window.location.reload(true)', 1000);
        } else {
            notie.alert(3, "Произошла ошибка("+data["code"]+")!", 3);
            setTimeout('window.location.reload(true)', 1000);
        }
        preloader.off();
    }, "json");
}

function EditParticipantData_Start() {
    var Index = $(this).parent('td').parent('tr').index();
    var Fullname = $('#participants_card_table').children('tbody').children('tr:eq('+Index+')').children('td:eq(0)');
    var Team = $('#participants_card_table').children('tbody').children('tr:eq('+Index+')').children('td:eq(2)');
    CurrentUserID = Fullname[0]["id"];
    Fullname = Fullname[0]["innerText"].split(" ");
    $('#participants_editing_name').val(Fullname[1]);
    $('#participants_editing_surname').val(Fullname[0]);
    $('#participants_editing_middlename').val(Fullname[2]);
    $('#participants_editing_name_input').addClass("is-dirty");
    $('#participants_editing_surname_input').addClass("is-dirty");
    $('#participants_editing_middlename_input').addClass("is-dirty");
    $('#participants_editing').fadeIn().css("display", "flex");
}

function ConfirmParticipantDataEditing() {
    preloader.on();
    ParName = $('#participants_editing_name').val();
    ParSurname = $('#participants_editing_surname').val();
    ParMiddlename = $('#participants_editing_middlename').val();
    ParSex = $("input[name='participants_editing_sex']:checked").val();
    ParTeam = $('#participants_editing_team').val();
    if (CheckParticipantFields(ParName, ParSurname, ParMiddlename, ParSex, ParTeam)) {
        $('.on_edit').fadeOut();
        EditParticipantData_Request(ParName, ParSurname, ParMiddlename, ParSex, ParTeam);
    }
}

function EditParticipantData_Request(ParName, ParSurname, ParMiddlename, ParSex, ParTeam) {
    $.post("../../requests/editparticipantdata.php", {
        token: Token,
        name: ParName,
        surname: ParSurname,
        middlename: ParMiddlename,
        sex: ParSex,
        team: ParTeam,
        login: CurrentUserID
    }, function (data) {
        if (data["code"] === 200) {
            notie.alert(1, "Данные успешно изменены!", 3);
            setTimeout('window.location.reload(true)', 1000);
        } else {
            notie.alert(3, "Произошла ошибка("+data["code"]+")!", 3);
            setTimeout('window.location.reload(true)', 1000);
        }
        preloader.off();
    }, "json");
}

function CancelParticipantsAdding() {
    $('#participants_adding').fadeOut();
    $('#participants_adding_name').val('');
    $('#participants_adding_surname').val('');
    $('#participants_adding_middlename').val('');
    $('#participants_adding_team').val('');
}
/*----------------*/

/* Employees */
function EmployeesAdding() {
    $('#employees_adding').fadeIn().css("display", "flex");
}

function EmployeesAddingConfirm() {
    preloader.on();
    EmpName = $('#employees_adding_name').val();
    EmpSurname = $('#employees_adding_surname').val();
    EmpMiddlename = $('#employees_adding_middlename').val();
    EmpSex = $("input[name='employee_adding_sex']:checked").val();
    EmpTeam = $('#employees_adding_team').val();
    EmpPost = $('#employees_adding_post').val();
    if (CheckEmployeesFields(EmpName, EmpSurname, EmpMiddlename, EmpTeam, EmpPost)) {
        $('.on_edit').fadeOut();
        AddEmployees(EmpName, EmpSurname, EmpMiddlename, EmpSex, EmpTeam, EmpPost);
    }
}

function AddEmployees(EmpName, EmpSurname, EmpMiddlename, EmpSex, EmpTeam, EmpPost) {
    $.post("../../requests/addemployee.php", {
        token: Token,
        name: EmpName,
        surname: EmpSurname,
        middlename: EmpMiddlename,
        sex: EmpSex,
        team: EmpTeam,
        post: EmpPost
    }, function (data) {
        if (data["code"] === 200) {
            notie.alert(1, "Сотрудник успешно добавлен!", 3);
            setTimeout('window.location.reload(true)', 1000);
        } else {
            notie.alert(3, "Произошла ошибка("+data["code"]+")!", 3);
            setTimeout('window.location.reload(true)', 1000);
        }
        preloader.off();
    }, "json");
}

function CheckEmployeesFields(EmpName, EmpSurname, EmpMiddlename, EmpTeam, EmpPost) {
    var Result = true;
    if(EmpTeam.length > 0) {
        if (!CheckInputData(EmpTeam, "employees_adding_team", false)) {
            Result = false;
        }
    }
    if (!CheckInputData(EmpName, "employees_adding_name", false)) {
        Result = false;
    }
    if (!CheckInputData(EmpSurname, "employees_adding_surname", false)) {
        Result = false;
    }
    if (!CheckInputData(EmpMiddlename, "employees_adding_middlename", false)) {
        Result = false;
    }
    if (!CheckInputData(EmpPost, "employees_adding_post", false)) {
        Result = false;
    }
    return Result;
}

function DeleteEmployee(obj) {
    preloader.on();
    var ID = obj["currentTarget"]["id"].substr(16);
    $.post("../../requests/deleteemployee.php", {token: Token, userID: ID}, function (data) {
        if (data["code"] === 200) {
            notie.alert(1, "Сотрудник успешно удалён!", 3);
            setTimeout('window.location.reload(true)', 1000);
        } else {
            notie.alert(3, "Произошла ошибка("+data["code"]+")!", 3);
            setTimeout('window.location.reload(true)', 1000);
        }
        preloader.off();
    }, "json");
}

function CancelEmployeesAdding() {
    $('#employees_adding').fadeOut();
    $('#employees_adding_name').val('');
    $('#employees_adding_surname').val('');
    $('#employees_adding_middlename').val('');
    $('#employees_adding_sex').val('');
    $('#employees_adding_team').val('');
    $('#employees_adding_post').val('');
}

function ChangeAllowCategory(data) {
    preloader.on();
    var ID = data["currentTarget"]["id"];
    var Element = $('#'+ID);
    ID = data["currentTarget"]["id"].substr(16);
    var Data  = ID.split("-");
    if(Element.prop('checked')){
        ChangeCategoryState(1, Data[1], Data[0]);
    } else {
        ChangeCategoryState(0, Data[1], Data[0]);
    }
}

function EditEmployeeData_Start() {
    var Index = $(this).parent('td').parent('tr').index();
    var Fullname = $('#employees_card_table').children('tbody').children('tr:eq('+Index+')').children('td:eq(0)');
    var Post = $('#employees_card_table').children('tbody').children('tr:eq('+Index+')').children('td:eq(2)');
    CurrentUserID = Fullname[0]["id"];
    Fullname = Fullname[0]["innerText"].split(" ");
    Post = Post[0]["innerText"];
    $('#employees_editing_name').val(Fullname[1]);
    $('#employees_editing_surname').val(Fullname[0]);
    $('#employees_editing_middlename').val(Fullname[2]);
    $('#employees_editing_post').val(Post);
    $('#employees_editing_name_input').addClass("is-dirty");
    $('#employees_editing_surname_input').addClass("is-dirty");
    $('#employees_editing_middlename_input').addClass("is-dirty");
    $('#employees_editing_post_input').addClass("is-dirty");
    $('#employees_editing').fadeIn().css("display", "flex");
}

function ConfirmEmployeeDataEditing() {
    preloader.on();
    EmpName = $('#employees_editing_name').val();
    EmpSurname = $('#employees_editing_surname').val();
    EmpMiddlename = $('#employees_editing_middlename').val();
    EmpSex = $("input[name='employees_editing_sex']:checked").val();
    EmpTeam = $('#employees_editing_team').val();
    EmpPost = $('#employees_editing_post').val();
    if (CheckEmployeesFields(EmpName, EmpSurname, EmpMiddlename, EmpTeam, EmpPost)) {
        $('.on_edit').fadeOut();
        EditEmployeeData_Request(EmpName, EmpSurname, EmpMiddlename, EmpSex, EmpTeam, EmpPost);
    }
}

function EditEmployeeData_Request(EmpName, EmpSurname, EmpMiddlename, EmpSex, EmpTeam, EmpPost) {
    $.post("../../requests/editemployeedata.php", {
        token: Token,
        name: EmpName,
        surname: EmpSurname,
        middlename: EmpMiddlename,
        sex: EmpSex,
        team: EmpTeam,
        post: EmpPost,
        login: CurrentUserID
    }, function (data) {
        if (data["code"] === 200) {
            notie.alert(1, "Данные успешно изменены!", 3);
            setTimeout('window.location.reload(true)', 1000);
        } else {
            notie.alert(3, "Произошла ошибка("+data["code"]+")!", 3);
            setTimeout('window.location.reload(true)', 1000);
        }
        preloader.off();
    }, "json");
}

function ChangeCategoryState(state, categoryID, userID) {
    $.post('../../requests/changeallowcategory.php', {token: Token, state: state, categoryID: categoryID, userID: userID}, function (data) {
        if(data["code"] === 200){
            notie.alert(1, "Разрешение успешно изменено!", 3);
        } else {
            notie.alert(3, "Произошла ошибка("+data["code"]+")!", 3);
        }
        preloader.off();
    }, "json");
}
/*----------------*/

/* Additional Settings */
function ChangeAdditionalSetting(obj) {
   var SettingID = obj["currentTarget"]["id"].substr(7);
   if($(this).prop("checked")){
       $.post('../../requests/changeadditionalsettings.php', {token: Token, settingName: SettingID, value: "1"}, function (data) {
           if (data["code"] === 200) {
               notie.alert(1, "Данные успешно изменены!", 3);
               setTimeout('window.location.reload(true)', 1000);
           } else {
               notie.alert(3, "Произошла ошибка("+data["code"]+")!", 3);
               setTimeout('window.location.reload(true)', 1000);
           }
       }, "json");
   } else {
       $.post('../../requests/changeadditionalsettings.php', {token: Token, settingName: SettingID, value: "0"}, function (data) {
           if (data["code"] === 200) {
               notie.alert(1, "Данные успешно изменены!", 3);
               setTimeout('window.location.reload(true)', 1000);
           } else {
               notie.alert(3, "Произошла ошибка("+data["code"]+")!", 3);
               setTimeout('window.location.reload(true)', 1000);
           }
       }, "json");
   }
}
/*----------------*/

/* Teams */
function AddTeam_Start() {
    $('#team_adding').fadeIn().css("display", "flex");
}

function AddTeam_Confirm() {
    $('.on_edit').fadeOut();
    preloader.on();
    var TeamName = $('#team_adding_name').val();
    if(CheckInputData(TeamName, "team_adding", false)){
        AddTeam_Request(TeamName);
    }
}

function AddTeam_Request(TeamName) {
    $.post("../../requests/addteam.php", {token: Token, teamName: TeamName}, function (data){
        if(data["code"] == 200){
            notie.alert(1, "Данные успешно добавлены", 3);
            setTimeout('window.location.reload(true)', 1000);
        } else {
            notie.alert(3, "Произошла ошибка("+data["code"]+")!", 3);
            setTimeout('window.location.reload(true)', 1000);
        }
        preloader.off();
    }, "json");
}

function AddTeam_Cancel() {
    $("#team_adding_name").val("");
    $('.on_edit').fadeOut();
}

function EditTeam_Start(obj) {
    CurrentTeamName = obj["currentTarget"]["id"].substr(10);
    $('#team_editing').fadeIn().css("display", "flex");
}

function EditTeam_Confirm() {
    $('.on_edit').fadeOut();
    preloader.on();
    var TeamName = $('#team_editing_name').val();
    if(CheckInputData(TeamName, "team_editing", false)){
        EditTeam_Request(TeamName);
    }
}

function EditTeam_Cancel() {
    $("#team_editing_name").val("");
    $('.on_edit').fadeOut();
}

function EditTeam_Request(TeamName) {
    $.post("../../requests/editteam.php", {token: Token, teamNameNew: TeamName, teamNameOld: CurrentTeamName}, function (data){
        if(data["code"] == 200){
            notie.alert(1, "Данные успешно изменены!", 3);
            setTimeout('window.location.reload(true)', 1000);
        } else {
            notie.alert(3, "Произошла ошибка("+data["code"]+")!", 3);
            setTimeout('window.location.reload(true)', 1000);
        }
        preloader.off();
    }, "json");
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
    $('#participants_adding-cancel').click(CancelParticipantsAdding);
    $('#participants_adding-confirm').click(ParticipantsAddingConfirm);
    $('#button_employees').click(EmployeesAdding);
    $('#employees_adding-cancel').click(CancelEmployeesAdding);
    $('#employees_adding-confirm').click(EmployeesAddingConfirm);
    $('#participants_card_table').ReStable({
        keepHtml: true,
        rowHeaders: false,
        maxWidth: 810
    });
    $('#employees_card_table').ReStable({
        keepHtml: true,
        rowHeaders: false,
        maxWidth: 810
    });
    $('.employee_category_switch').click(ChangeAllowCategory);
    $('.participants_table_delete').click(DeleteParticipant);
    $('.employees_table_delete').click(DeleteEmployee);
    $('.participants_table_edit').click(EditParticipantData_Start);
    $('#participants_editing-confirm').click(ConfirmParticipantDataEditing);
    $('#participants_editing-cancel').click(function () {
        $('.on_edit').fadeOut();
    });
    $('.employees_table_edit').click(EditEmployeeData_Start);
    $('#employees_editing-confirm').click(ConfirmEmployeeDataEditing);
    $('#employees_editing-cancel').click(function () {
        $('.on_edit').fadeOut();
    });
    $('.additional_settings_switch').click(ChangeAdditionalSetting);
    $('#actions_card_table').ReStable({
        keepHtml: true,
        rowHeaders: false,
        maxWidth: 810
    });
    $('.category-edit').click(EditCategoryName_Start);
    $('#categories_editing-confirm').click(EditCategoryName_Confirm);
    $('#categories_editing-cancel').click(EditCategoryName_Cancel);
    $('#button_teams').click(AddTeam_Start);
    $('#team_adding-confirm').click(AddTeam_Confirm);
    $('#team_adding-cancel').click(AddTeam_Cancel);
    $('#team_editing-confirm').click(EditTeam_Confirm);
    $('#team_editing-cancel').click(EditTeam_Cancel);
    $('.team_table_edit').click(EditTeam_Start);
});
