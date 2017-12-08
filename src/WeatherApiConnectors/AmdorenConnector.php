<?php
/*
	Marcin Michałek
	08.12.2017
	AmdorenConnector.php
*/

namespace App\WeatherApiConnectors;

use App\WeatherApiConnectors\WeatherConnectorInterface;


class AmdorenConnector implements WeatherConnectorInterface{
		
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
	
		//$url = 'http://api.weatherunlocked.com/api/current/'.$this->geoLat.','.$this->geoLon.'?lang=pl&app_id=29b1e0bd&app_key=0676d88b0f9eb4cd08a431d8d15b056e';
		$url = 'http://www.amdoren.com/api/weather.php?api_key=We7tPYadrDfScKUqQYG4KJF3e8Usuh&lat='.$this->geoLat.'&lon='.$this->geoLon;
		
		
		try{
			$result = json_decode(file_get_contents($url));
		}catch(Exception $e){
			return 0;
		}		
		
		$f = $result->forecast;
		$d = date('Y-m-d');
		foreach($f as $a){
			
			if($a->date == $d){
				$this->temperature = $a->avg_c;
				$this->img = 'http://www.amdoren.com/media/' . $a->icon;
				$this->description = $a->summary;
				$this->windSpeed = 0;
			}
		}
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