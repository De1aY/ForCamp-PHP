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
	Waves.attach('#profile');
	Waves.attach('#all');
	Waves.attach('#group');
	Waves.attach('#collapse-button');
	Waves.attach('#exit');
	Waves.init();
}

function GetLogin(){
	preloader.on();
	$.post('../requests/getuserlogin.php', {token: GetToken(), platform: "web"}, function(Resp) {
		Resp = JSON.parse(Resp);
		if(Resp["code"] == 200){
			SetLogin(Resp);
		}
		else{
			window.location = "../exit.php";
		}
	});
}

function SetLogin(Data){
	$('#profile').attr('href', 'profile.php?login='+Data['login']);
	preloader.off();
}

function GetToken(){
	return $('#token').text();
}

jQuery(document).ready(function($){
	GetLogin();
	ActivateWavesEffect();
});