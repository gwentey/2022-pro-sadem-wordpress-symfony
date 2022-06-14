<?php
// business : logique métier 
namespace App\Business;

use App\Manager\ApiWordpressManager;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Article;

class ArticleBusiness
{
    public $apiWordpressManager;
    public $articleRepository;
    public $doctrine;


    public function __construct(ApiWordpressManager $apiWordpressManager, ArticleRepository $articleRepository, ManagerRegistry $doctrine)
    {
        $this->apiWordpressManager = $apiWordpressManager;
        $this->articleRepository = $articleRepository;
        $this->doctrine = $doctrine;
    }

    public function refreshArticles()
    {

        // récupération et acualisation des articles
        // récupération des articles de notre api
        $articlesActualise = $this->apiWordpressManager->getAllArticles();

        // récupération de notre manager d'entité
        $entityManager = $this->doctrine->getManager();

        // parcours des articles
        foreach ($articlesActualise as $articleActualise) {

            $article = $this->articleRepository->find($articleActualise['id']);

            // si il y a une instance on crée un objcet Article
            if (!$article instanceof Article) {

                $article = new Article();

                $article->setId($articleActualise['id']);
            }

            $article->setDateCreation($articleActualise['date_creation']);
            $article->setDateModification($articleActualise['date_modification']);
            $article->setTitre($articleActualise['titre']);
            $article->setContent($articleActualise['content']);
            $article->setDescription($articleActualise['description']);
            $article->setHeader(json_encode($articleActualise['header']));
            $article->setScript(json_encode($articleActualise['script']));
            $article->setTags($articleActualise['tags']);
            $article->setCategories($articleActualise['categories']);
            $article->setFeaturedMedia($articleActualise['featured_media']);
            $article->setAuteur($articleActualise['auteur']);

            // on place la visilité à true par défaut
            $article->setVisibility(true);

            $entityManager->persist($article);

            $entityManager->flush();
        }

        // supression des articles dans la bdd inexistants
        $lesArticles =  $this->articleRepository->findAll();

        foreach ($lesArticles as $art) {
            $exist = false;
            foreach ($articlesActualise as $articleAPI) {
                if ($art->getId() == $articleAPI['id']) {
                    $exist = true;
                }
            }
            if (!$exist) {
                $entityManager->remove($art);
                $entityManager->flush();
            }
        }
    }

    public function refreshArticle($id)
    {

        // récupération et acualisation des articles
        // récupération des articles de notre api
        $articleActualise = $this->apiWordpressManager->getArticleById($id);

        // récupération de notre manager d'entité
        $entityManager = $this->doctrine->getManager();

        // on récupère l'article passé en paramètre
        $article = $this->articleRepository->find($id);

        // si l'article n'est pas null (n'est pas suprimée coté API) on le MAJ
        if ($articleActualise != null) {

            $article->setDateCreation($articleActualise['date_creation']);
            $article->setDateModification($articleActualise['date_modification']);
            $article->setTitre($articleActualise['titre']);
            $article->setContent($articleActualise['content']);
            $article->setDescription($articleActualise['description']);
            $article->setHeader(json_encode($articleActualise['header']));
            $article->setScript(json_encode($articleActualise['script']));
            $article->setTags($articleActualise['tags']);
            $article->setCategories($articleActualise['categories']);
            $article->setFeaturedMedia($articleActualise['featured_media']);
            $article->setAuteur($articleActualise['auteur']);

            $entityManager->persist($article);

            $entityManager->flush();

        } else {
            // l'article n'existe plus
            $entityManager->remove($article);
            $entityManager->flush();
        }

    }

    public function changeVisibilityArticle($id){

        $entityManager = $this->doctrine->getManager();
        $article = $this->articleRepository->find($id);

        if($article->getVisibility() == true){
        $article->setVisibility(false);
        } else {
        $article->setVisibility(true);
        }

        $entityManager->persist($article);
        $entityManager->flush();
        
    }
}
