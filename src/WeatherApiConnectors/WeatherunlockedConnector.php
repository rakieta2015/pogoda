<?php
/*
	Marcin Michałek
	08.12.2017
	WeatherunlockedConnector.php
*/

namespace App\WeatherApiConnectors;

use App\WeatherApiConnectors\WeatherConnectorInterface;


class WeatherunlockedConnector implements WeatherConnectorInterface{
		
	private $geoLat;
	private $geoLon;
	private $temperature;
	private $img;
	private $description;
	private $windSpeed;
		
    public function setGeoLat( $geoLat ){
		$this->geoLat = $geoLat;		
	}
	
    public function setGeoLon( $geoLon ){
		$this->geoLon = $geoLon;
	}
	
	public function apiConnect(){
	
		$url = 'http://api.weatherunlocked.com/api/current/'.$this->geoLat.','.$this->geoLon.'?lang=pl&app_id=29b1e0bd&app_key=0676d88b0f9eb4cd08a431d8d15b056e';
		
		try{
			$result = json_decode(file_get_contents($url));
		}catch(Exception $e){
			return 0;
		}		
		
		$this->temperature 	= $result->temp_c;
		$this->img 			= '/assets/icons/' . $result->wx_icon;
		$this->description 	= $result->wx_desc;
		$this->windSpeed 	= $result->windspd_kmh;
		return 1;
	}
	
	public function getTemperature(){
		return $this->temperature;		
	}
	
	public function getImg(){
		return $this->img;
	}

	public function getDescription(){
		return $this->description;
	}
	
	public function getWindSpeed(){
		return $this->windSpeed;
	}	
}