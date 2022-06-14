<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AproposController extends AbstractController
{
    #[Route('/apropos', name: 'apropos')]
    public function index(): Response
    {
        return $this->render('Front/apropos.html.twig', [
            'controller_name' => 'AproposController',
        ]);
    }
}
