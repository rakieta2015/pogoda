<?php 
/*
	Marcin Michałek
	07.12.2017
	GetCitiesService.php
*/

namespace App\Service;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\ORM\EntityManagerInterface;


class GetCitiesService{

	protected $tokenStorage;
	protected $em;

    public function __construct(TokenStorageInterface $tokenStorage, EntityManagerInterface $em)
    {
       $this->tokenStorage = $tokenStorage;
	   $this->em = $em;
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
	
	private function getDefaultCityList(){

		$cities = $this->em->createQueryBuilder()
			->select('c.id, c.name')
			->from('App:City', 'c')
			->andWhere('c.baseCity = 1')
			->getQuery()
			->getResult();	
		if(empty($cities)){
			return array();
		}
		return $cities;
	}
	
	private function getUserCityList($userId){
		$temp = $this->getDefaultCityList();
		$cities = $this->em->createQueryBuilder()
			->select('c.id, c.name')
			->from('App:City', 'c')
			->andWhere('c.userId = :id')
			->setParameter(':id', $userId)
			->getQuery()
			->getResult();
		if(empty($cities)){
			return $temp;
		}
		foreach($temp as $t){
			array_push($cities, array('id'=>$t['id'], 'name' => $t['name']));
		}
		return $cities;
	}
	
    public function getCityList(){
		$user = $this->getUser();
		if(empty($user)){
			return $this->getDefaultCityList();
		}
		return $this->getUserCityList($user->getId());
	}

}