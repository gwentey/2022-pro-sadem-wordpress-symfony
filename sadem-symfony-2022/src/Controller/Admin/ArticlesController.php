<?php

namespace App\Controller\Admin;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Business\ArticleBusiness;
use App\Entity\Article;


class ArticlesController extends AbstractController
{

    public $doctrine;
    public $articleBusiness;

    public function __construct(ManagerRegistry $doctrine, ArticleBusiness $articleBusiness){

        $this->articleBusiness = $articleBusiness;
        $this->doctrine = $doctrine;
    }

    
    #[Route('/refreshArticles', name: 'refreshArticles')]
    public function refreshArticles(): RedirectResponse
    {
        $this->articleBusiness->refreshArticles();
        return $this->redirectToRoute('articles');

    }

    #[Route('/refreshArticle/{id}', name: 'refreshArticle')]
    public function refreshArticle($id): RedirectResponse
    {
        $this->articleBusiness->refreshArticle($id);
        return $this->redirectToRoute('articles');

    }

    #[Route('/changeVisibilityArticle/{id}', name: 'changeVisibilityArticle')]
    public function changeVisibilityArticle($id): RedirectResponse
    {
        $this->articleBusiness->changeVisibilityArticle($id);
        return $this->redirectToRoute('articles');

    }

    #[Route('/articles', name: 'articles')]
    public function index(): Response
    {
       $lesArticles =  $this->doctrine->getRepository(Article::class)->findAll();

        return $this->render('Admin/articles.html.twig', [
            'controller_name' => 'ArticlesController',
            'articles' => $lesArticles
        ]);
    }


}

