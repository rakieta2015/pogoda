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

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;


use App\Entity\City;

class CityController extends Controller
{
	
	/**
     * @Route("/user/cityList", name="cityList")
     */
    public function cityList()
    {
		$user = $this->get('security.token_storage')->getToken()->getUser();	
		$repository = $this->getDoctrine()->getRepository(City::class);	
		$result = $repository->findBy(
			['userId' => $user->getId()],
			['name' => 'ASC']
		);
		
		return $this->render('city/cityList.html.twig', array(
			'result' => $result
		));		
    }

	/**
     * @Route("/user/addCity", name="addCity")
     */	
	public function addCity(Request $request){
		$t = new City();
		
		$form = $this->createFormBuilder($t)
			->add('name', TextType::class, array('label' => 'Nazwa miasta',  'attr' => array('class'=>'form-control')))
			->add('geoLat', NumberType::class, array('label' => 'Długość geograficzna',  'attr' => array('class'=>'form-control')))
			->add('geoLon', TextType::class, array('label' => 'Szerokość geograficzna',  'attr' => array('class'=>'form-control')))
			->add('save', SubmitType::class, array('label' => 'Dodaj',  'attr' => array('class'=>'btn btn-primary btn-md')))
			->getForm();
			
		$form->handleRequest($request);		
		if($form->isSubmitted() && $form->isValid()){	
			$user = $this->get('security.token_storage')->getToken()->getUser();		
			$city = $form->getData();		
			$city->setUserId($user->getId());
			$em = $this->getDoctrine()->getManager();
			$em->persist($city);
			$em->flush();
			
			return $this->render(
				'app/info.html.twig',
				array(
					'info' => 'Dodano nowe miasto'
				)
			);				
		}
			
		return $this->render('city/addCity.html.twig', array(
			'form' => $form->createView()
		));				
	}

	/**
     * @Route("/user/editCity", name="editCity")
     */	
	public function editCity(Request $request){
		if($request->request->has('id')){
			$id = $request->request->get('id');
		}else{
			$id = $request->query->get('id');
		}
		$user = $this->get('security.token_storage')->getToken()->getUser();	
		$repository = $this->getDoctrine()->getRepository(City::class);
		$t = $repository->findOneBy(['id' => $id, 'userId' => $user->getId()]);
		
		$form = $this->createFormBuilder($t)
			->add('id', HiddenType::class, array('data' => $id, 'mapped' => false))		
			->add('name', TextType::class, array('label' => 'Nazwa miasta', 'attr' => array('class'=>'form-control')))
			->add('geoLat', NumberType::class, array('label' => 'Długość geograficzna', 'attr' => array('class'=>'form-control')))
			->add('geoLon', TextType::class, array('label' => 'Szerokość geograficzna', 'attr' => array('class'=>'form-control')))
			->add('save', SubmitType::class, array('label' => 'Edytuj', 'attr' => array('class'=>'btn btn-primary btn-md')))
			->getForm();
			
		$form->handleRequest($request);		
		if($form->isSubmitted() && $form->isValid()){			
			$city = $form->getData();		
			$em = $this->getDoctrine()->getManager();
			$em->persist($city);
			$em->flush();
			
			return $this->render(
				'app/info.html.twig',
				array(
					'info' => 'Edytowano miasto'
				)
			);				
		}
			
		return $this->render('city/addCity.html.twig', array(
			'form' => $form->createView()
		));				
	}	

	/**
     * @Route("/user/removeCity", name="removeCity")
     */		
	public function removeCity(Request $request){
		if($request->request->has('id')){
			$id = $request->request->get('id');
		}else{
			$id = $request->query->get('id');
		}
		$em = $this->getDoctrine()->getManager();		
		$user = $this->get('security.token_storage')->getToken()->getUser();	
		$repository = $this->getDoctrine()->getRepository(City::class);
		$city = $repository->findOneBy(['id' => $id, 'userId' => $user->getId()]);		
		
		if(!empty($city)){
			$em->remove($city);
			$em->flush();
		}
		return $this->redirectToRoute('cityList');	
	}
	
}