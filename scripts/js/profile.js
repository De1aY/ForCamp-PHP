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

function SetFullName(){
	preloader.on();
	$.post('../requests/getuserdata.php', {platform: 'web', token: GetToken(), login: GetLogin()}, function(Resp_Data) {
		Resp_Data = JSON.parse(Resp_Data)
		if(CheckResponse(Resp_Data)){
			SetUserData(Resp_Data);
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

function Capitalize(str){
	return str[0].toUpperCase()+str.substr(1);
}

function SetUserData(Data){
	$(".fullname_text").text(Data["Surname"]+" "+Data["Name"]+" "+Data["Middlename"]);
	$("title").text(Capitalize(Data["Surname"])+" "+Capitalize(Data["Name"]));
	$("#user_post").text(Data["Post"]);
	$('#user_team').text(Data["Team"]);
	$(".avatar").attr("src", Data["Avatar"]);
	preloader.off();
}

function GetUserOrganization(){
	$.post('../requests/getuserorganization.php', {login: GetLogin(), platform: "web", token: GetToken()}, function(Resp_Org){
		Resp_Org = JSON.parse(Resp_Org);
		if(CheckResponse(Resp_Org)){
			SetUserOrganization(Resp_Org);
		}
	});
}

function SetUserOrganization(Data) {
	$("#user_organization").text(Data["organization"]);
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

function GetTeamValue(){
	$.post('../requests/getteamvalue.php', {platform: 'web', token: GetToken(), login: GetLogin()}, function(Resp) {
		Resp = JSON.parse(Resp)
		if(CheckResponse(Resp)){
			$("#team_value").text(Resp["team_value"]);
		}
	});
}

function SetData(){
		$('#profile').attr('href', 'profile.php?login='+GetLogin());
		$('#user_login').text(GetLogin());
		GetTeamValue();
		GetUserOrganization();
		SetFullName();
}

function EditLoginInf(){
	$('#user_login').css('border-bottom',"2px solid #000");
	$('#edit_login_inf').addClass("animated fadeOut");
	$('#edit_login_inf').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
		$('#edit_login_inf').hide();
		$('#accept_login_inf').show();
		$('#accept_login_inf').addClass("animated fadeIn");
		$('#cancel_login_inf').show();
		$('#cancel_login_inf').addClass("animated fadeIn");
		$('#cancel_login_inf').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
			$('#accept_login_inf').removeClass("animated fadeIn");
			$('#cancel_login_inf').removeClass("animated fadeIn");
			$('#edit_login_inf').removeClass("animated fadeOut");
		});
	});
}

function CancelLoginInf(){
	$('#accept_login_inf').addClass("animated fadeOut");
	$('#cancel_login_inf').addClass("animated fadeOut");
	$('#cancel_login_inf').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
		$('#accept_login_inf').hide();
		$('#cancel_login_inf').hide();
		$('#edit_login_inf').show();
		$('#edit_login_inf').addClass("animated fadeIn");
		$('#edit_login_inf').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
			$('#accept_login_inf').removeClass("animated fadeOut");
			$('#cancel_login_inf').removeClass("animated fadeOut");
			$('#edit_login_inf').removeClass("animated fadeIn");
		});
	});
}

jQuery(document).ready(function($){
	preloader.on();
	SetData();
	$('#edit_login_inf').click(EditLoginInf);
	$('#cancel_login_inf').click(CancelLoginInf);
});