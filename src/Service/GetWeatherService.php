<?php 
/*
	Marcin Michałek
	07.12.2017
	GetWeatherService.php

*/

namespace App\Service;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\WeatherApiConnectors\WeatherunlockedConnector;
use App\WeatherApiConnectors\AmdorenConnector;

use App\Entity\CityWeather;

class GetWeatherService{

	protected $tokenStorage;
	protected $em;
	protected $cityId;
	protected $cityName;
	protected $geoLat;
	protected $geoLon;
	
    public function __construct(TokenStorageInterface $tokenStorage, EntityManagerInterface $em)
    {
		$this->tokenStorage = $tokenStorage;
		$this->em = $em;
		$this->cityId = 0;
		$cityName = 'none';
		$geoLat = 0;
		$geoLon = 0;	   
    }

	private function getUser(){
		$token = $this->tokenStorage->getToken();
		if(empty($token)){
			return 0;
		}
		$user = $token->getUser();
		if($user == 'anon.'){
			return 0;
		}
		return $user;
	}	

	public function setCityId($cityId){
		$this->cityId = $cityId;		
		$user = $this->getUser();
		if(empty($user)){
			return 0;
		}
		$cities = $this->em->createQueryBuilder()
			->select('c.name, c.geoLat, c.geoLon')
			->from('App:City', 'c')
			->andWhere('c.userId = :userId or c.baseCity = 1')
			->andWhere('c.id = :cityId')
			->setParameter(':userId', $user->getId())
			->setParameter(':cityId', $cityId)
			->getQuery()
			->getResult();
		if(empty($cities)){
			return 0;
		}
		$this->cityName = $cities[0]['name'];
		$this->geoLat = $cities[0]['geoLat'];
		$this->geoLon = $cities[0]['geoLon'];
		return 1;
	}

	public function getCityName(){
		return $this->cityName;
	}
	
	public function getWeatherFromDb(){
		
		$r = $this->em->getRepository('App:CityWeather')->findOneBy(array('cityId' => $this->cityId));
		if(empty($r)){
			return 0;
		}
		
		return array(
			'temperature' 		=> $r->getTemperature(),
			'img' 				=> $r->getImg(),
			'description' 		=> $r->getDescription(),
			'windSpeed' 		=> $r->getWindSpeed()
		);		
	}
	/*
	public function saveWeatherToDb($w){
		$r = $this->getWeatherFromDb();
		if(empty($r)){
			$r = new CityWeather();
			$r->setImg($w->getImg());
			$r->setTemperature($w->getTemperature());
			$r->setDescription($w->getDescription());
			$r->setWindSpeed($w->getWindSpeed());
			$r->setCityId($this->cityId);			
			$this->em->persist($r);
			$this->em->flush();
			$this->em->clear();					
		}else{
			$r->setImg($w->getImg());
			$r->setTemperature($w->getTemperature());
			$r->setDescription($w->getDescription());
			$r->setWindSpeed($w->getWindSpeed());
			$this->em->flush();
			$this->em->clear();				
		}		
	}
	*/
	
	public function saveWeatherToDb($w){
		$r = $this->em->getRepository('App:CityWeather')->findOneBy(array('cityId' => $this->cityId));
		if(empty($r)){
			$r = new CityWeather();
			$r->setImg($w->getImg());
			$r->setTemperature($w->getTemperature());
			$r->setDescription($w->getDescription());
			$r->setWindSpeed($w->getWindSpeed());
			$r->setCityId($this->cityId);			
			$this->em->persist($r);
			$this->em->flush();
			$this->em->clear();					
		}else{
			$r->setImg($w->getImg());
			$r->setTemperature($w->getTemperature());
			$r->setDescription($w->getDescription());
			$r->setWindSpeed($w->getWindSpeed());
			$this->em->flush();
			$this->em->clear();					
		}		
	}	
	
	public function getWeather(){
		$weatherSource = '';
		$user = $this->getUser();
		if(empty($user)){
			$weatherSource = 'Weatherunlocked';
		}
		if(empty($user->getWeatherSource())){
			$weatherSource = 'Weatherunlocked';
		}else{
			$weatherSource = $user->getWeatherSource();
		}
		switch($weatherSource){
			case 'Weatherunlocked':
				$w = new WeatherunlockedConnector();
			break;
			case 'Amdoren':
				$w = new AmdorenConnector();
			break;
			default:
				$w = new WeatherunlockedConnector();
			break;
		}
		
		$w->setGeoLat( $this->geoLat );
		$w->setGeoLon( $this->geoLon );
		if(!$w->apiConnect()){
			return $this->getWeatherFromDb; //pobranie pogody z bazy danych
		}else{
			$this->saveWeatherToDb($w); //zapis pogody do bazy danych
			
			return array(
				'temperature' 		=> $w->getTemperature(),
				'img' 				=> $w->getImg(),
				'description' 		=> $w->getDescription(),
				'windSpeed' 		=> $w->getWindSpeed(),
				'source' 			=> $weatherSource
			);			
		}
	}
}