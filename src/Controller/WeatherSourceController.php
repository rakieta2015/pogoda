<?php
/*
	Marcin Michałek
	08.12.2017
	AppController.php
*/

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\User;

class WeatherSourceController extends Controller
{
	
	/**
     * @Route("/user/weatherSource", name="weatherSource")
     */
    public function cityList(Request $request)
    {
		if($request->request->has('source')){
			$thisUser = $this->get('security.token_storage')->getToken()->getUser();
			$em = $this->getDoctrine()->getManager();
			$user = $em->getRepository('App:User')->findOneBy(array('id' => $thisUser->getId()));
			$user->setWeatherSource( $request->request->get('source') );
			$em->flush();
			$em->clear();
			$source = $request->request->get('source');
		}else{
			$user = $this->get('security.token_storage')->getToken()->getUser();
			$source = $user->getWeatherSource();
		}
		$sources = array(
			'Weatherunlocked',
			'Amdoren'
		);
		$user = $this->get('security.token_storage')->getToken()->getUser();	
		return $this->render('weatherSource/weatherSource.html.twig', array(
			'source' 	=> $source,
			'sources' 	=> $sources
		));		
    }


	
}