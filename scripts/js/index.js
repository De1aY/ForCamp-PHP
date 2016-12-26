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


jQuery(document).ready(function($){
	ActivateWavesEffect();
});