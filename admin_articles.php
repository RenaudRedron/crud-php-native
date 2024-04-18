<?php
include ('init/_function.php');

// On controle que l'utilisateur possède le role 'admin'
// SI il ne possède pas le role admin alors on le redirige vers index.php
if (getRole($pdo, $_SESSION['user']['login']) != 'admin') {
    header('Location: index.php');
}

$numberArticle = countArticle($pdo);

if (isset($_GET['deleteArticleId'])) {

    // SI l'article à supprimer existe en base de données
    if (findArticle($pdo, $_GET['deleteArticleId'])) {
        deleteArticle($pdo, $_GET['deleteArticleId']);
    }

}

include ('init/_header.php');
?>

<h2 class="w-100 mx-auto text-center p-4">Articles (<?= $numberArticle; ?>)</h2>

<div class="w-75 mx-auto text-left m-2">
    <a href="admin_create_article.php"><button class="btn bg-dark text-white">
            Ajouter un article
        </button></a>
</div>

<div class="table-responsive">

    <table class="table table-hover table-striped w-75 mx-auto">
        <thead>
            <tr>
                <th scope="col" class="text-center">ID</th>
                <th scope="col" class="text-center">Catégorie</th>
                <th scope="col" class="text-center">Marque</th>
                <th scope="col" class="text-center">Nom</th>
                <th scope="col" class="text-center">Prix (€)</th>
                <th scope="col" class="text-center"><img src="public/images/modifier.png" alt="Bouton de modification"
                        width="25px"></th>
                <th scope="col" class="text-center"><img src="public/images/supprimer.png" alt="Bouton de suppression"
                        width="25px"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (getArticles($pdo) as $article) { ?>
                <tr>
                    <th scope="row" class="text-center p-4 align-middle"><?= $article['id_article']; ?></th>
                    <td class="text-center p-4 align-middle"><?= getCategorie($pdo, $article['id_categorie'])['name']; ?>
                    </td>
                    <td class="text-center p-4 align-middle"><?= getMarque($pdo, $article['id_marque'])['name']; ?></td>
                    <td class="text-center p-4 align-middle"><?= htmlspecialchars($article['name']); ?></td>
                    <td class="text-center p-4 align-middle"><?= $article['price']; ?></td>
                    <td class="text-center p-4 align-middle"><a
                            href="admin_update_article.php?id_article=<?= $article['id_article'] ?>"><img
                                src="public/images/modifier.png" alt="Bouton de modification" width="25px"></a></td>
                    <td class="text-center p-4 align-middle"><a
                            href="admin_articles.php?deleteArticleId=<?= $article['id_article'] ?>"><img
                                src="public/images/supprimer.png" alt="Bouton de suppression" width="25px"></a></td>
                </tr>

            <?php } ?>

        </tbody>


    </table>
</div>
<?php
include ('init/_footer.php');
?>