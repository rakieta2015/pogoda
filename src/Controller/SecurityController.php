<?php
/*
	Marcin Michałek
	07.12.2017
	SecurityController.php
*/
// src/Controller/SecurityController.php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;


class SecurityController extends Controller
{
	
	/**
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $authUtils)
    {
		// get the login error if there is one
		$error = $authUtils->getLastAuthenticationError();

		// last username entered by the user
		$lastUsername = $authUtils->getLastUsername();

		return $this->render('security/login.html.twig', array(
			'last_username' => $lastUsername,
			'error'         => $error,
		));		
    }	
	
	/**
     * @Route("/logout", name="logout")
     */
	public function logoutAction(){
		return $this->render(
			'app/info.html.twig',
			array(
				'info' => 'Wylogowałeś się poprawnie'
			)
		);			
	}	
	
    public function topBar(Request $request, AuthenticationUtils $authUtils)
    {	
		$userIsActive = 1; 
		$token = $this->get('security.token_storage')->getToken();
		if($token == NULL){
			$userIsActive = 0;
		}	
		$user = $token->getUser();
		if($user == 'anon.'){		
			$userIsActive = 0;
		}	
		if($userIsActive == 0 ){
			// get the login error if there is one
			$error = $authUtils->getLastAuthenticationError();

			// last username entered by the user
			$lastUsername = $authUtils->getLastUsername();

			return $this->render('security/login.html.twig', array(
				'last_username' => $lastUsername,
				'error'         => $error,
			));				
		}
		return $this->render('security/userMenu.html.twig', array(
			'username' => $user->getUsername(),
		));		
    }	
	
	
}