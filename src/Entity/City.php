<?php
/*
	Marcin Michałek
	07.12.2017
	City.php
*/
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="city")
 */
class City{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;	
	
    /**
     * @ORM\Column(type="string", length=64)
     */
    private $name;
	
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $baseCity;	
	
    /**
     * @ORM\Column(type="decimal", precision=8, scale=2)
     */
    private $geoLat; //długość geo

    /**
     * @ORM\Column(type="decimal", precision=8, scale=2)
     */
    private $geoLon; //szerokość geo
	
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $userId;	

    public function setId()
    {
        $this->id = $id;
    }
	
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getBaseCity()
    {
        return $this->baseCity;
    }

    public function getGeoLat()
    {
        return $this->geoLat;
    }

    public function getGeoLon()
    {
        return $this->geoLon;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
	
    public function setBaseCity($baseCity)
    {
        $this->baseCity = $baseCity;
    }	
	
    public function setGeoLat($geoLat)
    {
        $this->geoLat = $geoLat;
    }

    public function setGeoLon($geoLon)
    {
        $this->geoLon = $geoLon;
    }	
	
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }	
}
