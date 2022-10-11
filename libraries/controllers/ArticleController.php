<?php

namespace Controllers;

class ArticleController extends Controller
{
    // EGAL A "\Models\ArticleModel";
    protected $modelName = \Models\ArticleModel::class;

    public function index()
    {
        /**
         * 1. Connexion à la base de données et récupération des articles
         */
        $articles = $this->model->findAll("created_at DESC");

        /**
         * 2. Affichage
         */
        $pageTitle = "Accueil";

        \Renderer::render('articles/index', compact('pageTitle', 'articles'));
    }

    public function show()
    {
        $articleComment = new \models\CommentModel();

        /**
         * 1. Récupération du param "id" et vérification de celui-ci
         */
        // On part du principe qu'on ne possède pas de param "id"
        $article_id = null;

        // Mais si il y'en a un et que c'est un nombre entier, alors c'est cool
        if (!empty($_GET['id']) && ctype_digit($_GET['id'])) {
            $article_id = $_GET['id'];
        }

        // On peut désormais décider : erreur ou pas ?!
        if (!$article_id) {
            die("Vous devez préciser un paramètre `id` dans l'URL !");
        }

        /**
         * 2. Connexion à la base de données et récupération de l'article en question
         * On va ici utiliser une requête préparée car elle inclue une variable qui provient de l'utilisateur : Ne faites
         * jamais confiance à ce connard d'utilisateur ! :D
         */
        $article = $this->model->find($article_id);

        /**
         * 3. Récupération des commentaires de l'article en question
         * Pareil, toujours une requête préparée pour sécuriser la donnée filée par l'utilisateur (cet enfoiré en puissance !)
         */
        $commentaires = $articleComment->findAllWithArticle($article_id);

        /**
         * 5. On affiche 
         */
        $pageTitle = $article['title'];
        \Renderer::render('articles/show', compact('pageTitle', 'article', 'commentaires', 'article_id'));
    }

    public function delete()
    {
        if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
            die("Ho ?! Tu n'as pas précisé l'id de l'article !");
        }

        $id = $_GET['id'];
        /**
         * 2. Connexion à la base de données et vérification que l'article existe bel et bien
         */
        $article = $this->model->find($id);
        if (!$article) {
            die("L'article $id n'existe pas, vous ne pouvez donc pas le supprimer !");
        }

        /**
         * 3. Réelle suppression de l'article
         */
        $this->model->delete($id);
        /**
         * 4. Redirection vers la page d'accueil
         */
        \Http::redirect('index.php');
    }
}
