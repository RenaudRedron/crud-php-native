<?php
include ('init/_function.php');

// On controle que l'utilisateur possède le role 'admin'
// SI il ne possède pas le role admin alors on le redirige vers index.php
if (getRole($pdo, $_SESSION['user']['login']) != 'admin') {
    header('Location: index.php');
}

$numberUser = countUser($pdo);
$numberArticle = countArticle($pdo);
$numberCategorie = countCategorie($pdo);
$numberMarque = countMarque($pdo);

include ('init/_header.php');
?>

<h2 class="w-100 mx-auto text-center p-4">Panneau d'administration</h2>

<div class="row justify-content-evenly m-2">

    <a class="p-2 m-2 bg-warning col-lg-2 col-md-4 text-white text-center text-decoration-none" href="admin_users.php">
        <div>
            <h4 class="p-2">Utilisateurs</h4>
            <hr>
            <p class="fs-4"><?= $numberUser; ?></p>
        </div>
    </a>

    <a class="p-2 m-2 bg-danger col-lg-2 col-md-4 text-white text-center text-decoration-none" href="admin_articles.php">
        <div>
            <h4 class="p-2">Articles</h4>
            <hr>
            <p class="fs-4"><?= $numberArticle; ?></p>
        </div>
    </a>

    <a class="p-2 m-2 bg-success col-lg-2 col-md-4 text-white text-center text-decoration-none" href="#">
        <div>
            <h4 class="p-2">Catégories</h4>
            <hr>
            <p class="fs-4"><?= $numberCategorie; ?></p>
        </div>
    </a>

    <a class="p-2 m-2 bg-primary col-lg-2 col-md-4 text-white text-center text-decoration-none" href="#">
        <div>
            <h4 class="p-2">Marques</h4>
            <hr>
            <p class="fs-4"><?= $numberMarque; ?></p>
        </div>
    </a>

    <a class="p-2 m-2 bg-info col-lg-2 col-md-4 text-white text-center text-decoration-none" href="#">
        <div>
            <h4 class="p-2">Commentaires</h4>
            <hr>
            <p class="fs-4">0</p>
        </div>
    </a>

</div>

<?php
include ('init/_footer.php');
?>