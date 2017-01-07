var AccessLogin = true;
var AccessPassword = true;

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

function Authorize() {
    preloader.on();
    var Login = GetLogin();
    var Password = GetPassword();
    if(AccessPassword === true && AccessLogin === true){
        $.post('../requests/authorize.php', {login: Login, password: Password}, function (response) {
            response = JSON.parse(response);
            if(response["code"] === 200){
                preloader.off()
                notie.alert(1, "Успешно");
                window.location = "../index.php";
            }
            else {
                preloader.off();
                $('#input_login').addClass("is-invalid");
                $('#input_password').addClass("is-invalid");
                notie.alert(3, "Неверный логин или пароль!");
            }
        });
    }
    else {
        preloader.off();
    }
}

function GetLogin(){
    var Login = $('#login').val();
    if(Login.length > 0){
        AccessLogin = true;
        return Login;
    }
    else {
        $('#input_login').addClass("is-invalid");
        AccessLogin = false;
        return Login;
    }
}

function GetPassword(){
    var Password = $('#password').val();
    if(Password.length > 0){
        AccessPassword = true;
        return Password;
    }
    else {
        $('#input_password').addClass("is-invalid");
        AccessPassword = false;
        return Password;
    }
}

jQuery('document').ready(function($){
    $('#submit').click(Authorize);
});