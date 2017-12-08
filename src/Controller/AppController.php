<?php
/*
	Marcin Michałek
	07.12.2017
	AppController.php
*/

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


use App\Service\GetCitiesService;
use App\Service\GetWeatherService;


class AppController extends Controller
{
	
	/**
     * @Route("/", name="app")
     */
    public function app(GetCitiesService $getCitiesService)
    {
		/*
		$url = 'http://api.weatherunlocked.com/api/current/51.5,-0.1?app_id=29b1e0bd&app_key=0676d88b0f9eb4cd08a431d8d15b056e';
		$x = file_get_contents($url);
		var_dump($x);
		*/
		
		$cities = $getCitiesService->getCityList();
		
		return $this->render('app/app.html.twig', array(
			'cities' => $cities
		));		
    }	

	/**
     * @Route("/getWeather", name="getWeather")
     */
    public function getWeather(GetWeatherService $getWeatherService, Request $request)
    {
		$isThere = $getWeatherService->setCityId($request->request->get('cityId'));
		if(empty($isThere)){
			return new JsonResponse(array(
				'error' 	=> 'yes',
				'message' 	=> 'Nie znaleziono miasta'
			));				
		}
		$cityName = $getWeatherService->getCityName();
		$weather = $getWeatherService->getWeather();
		
		return new JsonResponse(array(
			'error'		=> 'no',
			'cityName'	=> $cityName,
			'weather' 	=> $weather
		));	
    }
	
}