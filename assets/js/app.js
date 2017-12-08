/*
	Marcin Michałek
	07.12.2017
	app.js
*/


$(document).ready(function(){

	var self = this;

	this.buildWeatherDiv = function(cityName, weather){
		var t = '';
		t += '<h2>' + cityName + ' <img src="' + weather['img'] + '"></h2>';
		t += '<br>Temperatura: ' + weather['temperature'] + '&#8451;';
		t += '<br>Wiatr: ' + weather['windSpeed'] + ' km/h';
		t += '<br>Pogoda: ' + weather['description'];
		t += '<br>Źródło: ' + weather['source'];
		return t;
	}
	
	this.getWeaher = function(cityId){
		var data = { cityId: cityId };
		$.post("/getWeather", data, function(result){
			$('#weatherDiv').html(self.buildWeatherDiv(result['cityName'], result['weather']));
		});		
		
	}

	$(document).on('change', '#selectCity', function(){
		self.getWeaher($(this).val());
	});
	
	$(document).on('click', '#refresh', function(){
		self.getWeaher($('#selectCity').val());
	});
	
	self.getWeaher($('#selectCity').val());
	
});