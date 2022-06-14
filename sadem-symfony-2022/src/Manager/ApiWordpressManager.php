<?php
// Manager : adaptation des données
namespace App\Manager;

use App\Services\WordpressApiService;

class ApiWordpressManager
{

    public $wordpressApiService;

    public function __construct(WordpressApiService $wordpressApiService)
    {
        $this->wordpressApiService = $wordpressApiService;
    }

    /**
     * Permet d'obtenir tout les articles de façon exploitable
     *
     * @return Array retourne un tableau de tous les articles exploitables
     */
    public function getAllArticles(): array
    {
        $articles = $this->wordpressApiService->get('/posts');

        // traitement des données
        $i = 0;

        foreach ( (array) $articles as $article) {
            $i++;
            //Insertion du titre
            if (empty($article->title->rendered)) {
                $traitementArticles[$i]['titre'] = "Sans titre";
            } else {
                $traitementArticles[$i]['titre'] = $article->title->rendered;
            }

            // Insertion de l'id
            $traitementArticles[$i]['id'] = $article->id;

            // Insertion de la description
            $traitementArticles[$i]['description'] = $article->excerpt->rendered;

            // Insertion des dates 
            $traitementArticles[$i]['date_creation'] = date_create_from_format('Y-m-d', substr($article->date, 0, 10));
            $traitementArticles[$i]['date_modification'] =  date_create_from_format('Y-m-d', substr($article->modified, 0, 10));

            // information pour l'affichage
            $traitementArticles[$i]['header'] = $article->more_info->header;

            // Insertion du content 
            $traitementArticles[$i]['content'] = $article->content->rendered;

            //nécessiste l'extension activée
            $traitementArticles[$i]['script'] = $article->more_info->script;

            // Insertion des tags
            $traitementArticles[$i]['tags'] = $this->getNameTags($article->tags);

            // Insertion des la catégories
            $traitementArticles[$i]['categories'] = $this->getNameCategories($article->categories);

            // Insertion image mise en avant, si null on met une image not found
            if ($this->getUrlImage($article->featured_media)) {
                $traitementArticles[$i]['featured_media'] = $this->getUrlImage($article->featured_media);
            } else {
                $traitementArticles[$i]['featured_media'] = "/images/admin/notfound.png";
            }
            // auteur
            $traitementArticles[$i]['auteur'] = $article->author;
        }

        return $traitementArticles;
    }

    /**
     * Permet d'obtenir un article de façon exploitable avec son id
     *
     * @return Array|Null retourne un tableau ou null si l'article n'est pas trouvé
     */
    public function getArticleById($id): array|null
    {
        $article = $this->wordpressApiService->get('/posts/' . $id);

        // controle article existe
        if (isset($article->data->status) && ($article->data->status == 401 || $article->data->status == 404)) {
            return null;
        }

        //Insertion du titre
        if (empty($article->title->rendered)) {
            $traitementArticle['titre'] = "Sans titre";
        } else {
            $traitementArticle['titre'] = $article->title->rendered;
        }

        // Insertion de l'id
        $traitementArticle['id'] = $article->id;

        // Insertion de la description
        $traitementArticle['description'] = $article->excerpt->rendered;

        // Insertion des dates 
        $traitementArticle['date_creation'] = date_create_from_format('Y-m-d', substr($article->date, 0, 10));
        $traitementArticle['date_modification'] =  date_create_from_format('Y-m-d', substr($article->modified, 0, 10));

        // information pour l'affichage
        $traitementArticle['header'] = $article->more_info->header;

        // Insertion du content 
        $traitementArticle['content'] = $article->content->rendered;

        //nécessiste l'extension activée
        $traitementArticle['script'] = $article->more_info->script;

        // Insertion des tags
        $traitementArticle['tags'] = $this->getNameTags($article->tags);

        // Insertion des la catégories
        $traitementArticle['categories'] = $this->getNameCategories($article->categories);

        // Insertion image mise en avant
        $traitementArticle['featured_media'] = $this->getUrlImage($article->featured_media);

        // auteur
        $traitementArticle['auteur'] = $article->author;


        return $traitementArticle;
    }


    /**
     * Cherche l'id associé à l'id de la feature image, return null si inexistante
     *
     * @param Int $id est l'id de la feature image
     * @return Mixed retourne l'url de le la feature image ou null
     */
    public function getUrlImage($id)
    {
        if ($id != 0) {
            $result = $this->wordpressApiService->get('/media/' . $id);
            return $result->guid->rendered;
        }
        return null;
    }

    /**
     * Change les id des tags en nom 
     *
     * @param Array $tags est un tableau d'id de tags
     * @return Array $tagsWithName, les noms des tags
     */
    public function getNameTags($tags): array
    {
        $tagsWithName = array();

        foreach ($tags as $tag) {
            $result = $this->wordpressApiService->get('/tags/' . $tag);

            array_push($tagsWithName, $result->name);
        }
        return $tagsWithName;
    }

    /**
     * Change les id des catégories en nom 
     *
     * @param Array $categories est un tableau d'id de categories
     * @return Array $categoriesWithName, les noms des catégories
     */
    public function getNameCategories($categories): array
    {
        $categoriesWithName = array();

        foreach ($categories as $categorie) {
            $result = $this->wordpressApiService->get('/categories/' . $categorie);

            array_push($categoriesWithName, $result->name);
        }
        return $categoriesWithName;
    }
}
