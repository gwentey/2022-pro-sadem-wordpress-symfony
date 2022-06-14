<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Article;

class ArticleController extends AbstractController
{

    public $doctrine;

    public function __construct(ManagerRegistry $doctrine){
        $this->doctrine = $doctrine;
    }


    #[Route('/article/{id}', name: 'article')]
    public function index($id): Response
    {
        $article =  $this->doctrine->getRepository(Article::class)->find($id);

        $traitementArticles['header'] = json_decode($article->getHeader());

        $traitementArticles['description'] = $article->getContent();

        $traitementArticles['script'] = json_decode($article->getScript());

        
        return $this->render('Front/article.html.twig', [
            'controller_name' => 'ArticleController',
            'article' => $traitementArticles

        ]);
    }
}
