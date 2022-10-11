<h1>Nos articles</h1>

<?php foreach ($articles as $article) : ?>
    <h2><?= $article['title'] ?></h2>
    <small>Ecrit le <?= $article['created_at'] ?></small>
    <p><?= $article['introduction'] ?></p>
    <a href="index.php?controller=articleController&task=show&id=<?= $article['id'] ?>">Lire la suite</a>
    <a href="index.php?controller=articleController&task=delete&id=<?= $article['id'] ?>" onclick="return window.confirm(`Êtes vous sur de vouloir supprimer cet article ?!`)">Supprimer</a>
<?php endforeach ?>

<!-- titre professionnel developpeur web et web mobile -->

