<?php

namespace App\Controller\Front;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesPublicController extends AbstractController
{

    private $_articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->_articleRepository = $articleRepository;
    }


    #[Route('/articlesPublic', name: 'articlesPublic')]
    public function index(): Response
    {
        $articles = $this->_articleRepository->findAllPublic();


        return $this->render('Front/articlesPublic.html.twig', [
            'controller_name' => 'ArticlesPublicController',
            'articles' => $articles
        ]);
    }
}
