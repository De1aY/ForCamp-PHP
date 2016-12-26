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

function OnClickListener(){
	preloader.on();
	var Login = GetLogin();
	var Password = GetPassword();
	if(Login.length != 0 && Password.length !=0){
		CheckAuthInf(Login, Password);
	}
	else{
		Error("Не все поля заполнены!");
	}
}

function CheckAuthInf(User_Login, User_Password){
	$.post('../scripts/php/authorization.php', {login: User_Login, password: User_Password, platform: "web"}, function(data) {
		ParseResponse(data);
	});
}

function ParseResponse(Response){
	var Response = JSON.parse(Response);
	if(Response["code"] == 200){
		Success("Успешно");
		window.location = "../index.php";
	}
	else{
		Error("Неверный логин или пароль!");
	}
}

function Success(Message){
	preloader.off();
	notie.alert(1, Message, 5);
}

function Error(Message){
	preloader.off();
	notie.alert(3, Message, 5);
}

function GetLogin(){
	return $('#login').val();
}

function GetPassword(){
	return $('#password').val();
}

function SetOnClickListener(){
	$('#submit').click(OnClickListener);
}

function ActivateWavesEffect(){
	Waves.attach('#submit');
	Waves.init();
}

$(document).ready(function($){
	SetOnClickListener();
	ActivateWavesEffect();
});