<?php
/*
	Marcin Michałek
	07.12.2017
	CityWeather.php
*/
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="city_weather")
 */
class CityWeather{
	
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;	
	
    /**
     * @ORM\Column(type="string", length=64)
     */
    private $img;

    /**
     * @ORM\Column(type="decimal", precision=8, scale=2)
     */
    private $temperature; 

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cityId;	

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $description;	

    /**
     * @ORM\Column(type="decimal", precision=8, scale=2)
     */
    private $windSpeed;
 	
	
	public function getId(){
		return $this->id();
	}
	
	public function getImg(){
		return $this->img;
	}
	
	public function getTemperature(){
		return $this->temperature;
	}

	public function getCityId(){
		return $this->img;
	}
	
	public function setImg($img){
		$this->img = $img;
	}

	public function setTemperature($temperature){
		$this->temperature = $temperature;
	}

	public function setCityId($cityId){
		$this->cityId = $cityId;
	}

	public function setDescription($description){
		$this->description = $description;
	}
	
	public function getDescription(){
		return $this->description;
	}
	
	public function setWindSpeed($windSpeed){
		$this->windSpeed = $windSpeed;
	}
	
	public function getWindSpeed(){
		return $this->windSpeed;
	}
}
