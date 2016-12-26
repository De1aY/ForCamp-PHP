function OnClickListener(){
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
		window.location = "../index.php";
	}
	else{
		Error("Неверный логин или пароль!");
	}
}

function Error(Message){
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

$(document).ready(function(){
	SetOnClickListener();
});