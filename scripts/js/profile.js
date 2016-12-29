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
	$.post('../requests/getuserdata.php', {platform: 'web', token: GetToken(), login: GetLogin()}, function(Resp_Data) {
		Resp_Data = ToJSON(Resp_Data)
		if(CheckResponse(Resp_Data)){
			SetData(Resp_Data);
		}
		else{
			notie.alert(3, "Не удалось получить информацию о пользователе!");
		}
	});
}

function GetRequestParams(){
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

function Capitalize(str){
	return str[0].toUpperCase()+str.substr(1);
};

function SetData(Data){
	$(".Name").text(Data["Surname"]+" "+Data["Name"]+" "+Data["Middlename"]);
	$("title").text(Capitalize(Data["Surname"])+" "+Capitalize(Data["Name"]));
	$(".Avatar").attr("src", Data["Avatar"]);
	if(Data["owner"] == true){
		Owner();
	}
	preloader.off();
}

function GetUserOrganization(){
	$.post('../requests/getuserorganization.php', {login: GetLogin(), platform: "web", token: GetToken()}, function(Resp_Org){
		Resp_Org = ToJSON(Resp_Org);
		if(CheckResponse(Resp_Org)){
			SetOrganization(Resp_Org);
		}
		else{
			notie.alert(3, "Не удалось получить информацию о пользователе!");
			preloader.off();
		}
	});
}

function SetOrganization(Data){
	Text = $('title').text()
	$('title').text(Data["organization"]+Text);
	preloader.off();
}

function CheckResponse(Response){
	if(Response["code"] == 200){
		return true;
	}
	else{
		if(Response["code"] == 602){
			window.location = "../exit.php";
		}
		return false;
	}
}


jQuery(document).ready(function($){
	GetUserData();
	ActivateWavesEffect();
});