<?php

namespace App\Controller\Admin;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConnexionController extends AbstractController
{


    #[Route('/connexion', name: 'connexion')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('dashboard');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();


        return $this->render('Admin/connexion.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }



    #[Route('/deconnection', name: 'deconnection')]
    public function logout(): void{}

}