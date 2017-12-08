<?php
/*
	Marcin Michałek
	08.12.2017
	WeatherConnectorInterface.php
*/

namespace App\WeatherApiConnectors;

interface WeatherConnectorInterface
{
    public function setGeoLat( $geoLat );
    public function setGeoLon( $geoLon );
	public function apiConnect();
	public function getTemperature();
	public function getImg();
	public function getDescription();
	public function getWindSpeed();
}