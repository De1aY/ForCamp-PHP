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


function ActivateWavesEffect(){
	Waves.attach('#main');
	Waves.attach('#all');
	Waves.attach('#group');
	Waves.attach('#collapse-button');
	Waves.attach('#exit');
	Waves.attach('.Settings');
	Waves.attach('.Achievements');
	Waves.init();
}

function GetUserData(){
	preloader.on();
	$.post('../requests/getuserdata.php', {platform: 'web', token: GetToken(), login: GetLogin()}, function(Resp) {
		Resp = ToJSON(Resp)
		if(CheckResponse(Resp)){
			SetData(Resp);
			if(Resp["owner"] == true){
				Owner();
			}
		}
		else{
			notie.alert(3, "Не удалось получить информацию о пользователе!");
			preloader.off();
		}
	});
}

function GetRequestParams()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

function GetLogin(){
	return GetRequestParams()["login"];
}

function GetToken(){
	return $('#token').text();
}

function ToJSON(data){
	return JSON.parse(data);
}

function Owner(){
	$('.settings').text("личный кабинет");
}

function SetData(Data){
	$(".Name").text(Data["Surname"]+" "+Data["Name"]+" "+Data["Middlename"]);
	$("title").text("ForCamp | "+Data["Surname"]+" "+Data["Name"]+" "+Data["Middlename"]);
	$(".Avatar").attr("src", Data["Avatar"]);
	preloader.off();
}

function CheckResponse(Response){
	if(Response["code"] == 200){
		return true;
	}
	else{
		return false;
	}
}

jQuery(document).ready(function($){
	GetUserData();
	ActivateWavesEffect();
});