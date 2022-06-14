<?php

namespace App\Controller\Front;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'accueil')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAllPublic();

        return $this->render('Front/accueil.html.twig', [
            'controller_name' => 'AccueilController',
            'articles' => $articles
        ]);

    }
}