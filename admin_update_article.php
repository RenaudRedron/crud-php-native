<?php
include ('init/_function.php');

// On controle que l'utilisateur possède le role 'admin'
// SI il ne possède pas le role admin alors on le redirige vers index.php
// SINON SI le paramètre id_article de l'url n'existe pas ou qu'il n'est pas une valeur numérique alors on redirige vers admin_article
// SINON SI l'article n'existe pas alors on redirige vers admin_article
if (getRole($pdo, $_SESSION['user']['login']) != 'admin') {
    header('Location: index.php');
} else if (!isset($_GET['id_article']) || !is_numeric($_GET['id_article'])) {
    header('Location: admin_articles.php');
} else if (!findArticle($pdo, $_GET['id_article'])) {
    header('Location: admin_articles.php');
} else {
}

// On récupère l'article qui correspond à l'ID dans la super global $_GET['id_article']
$article = getArticle($pdo, $_GET['id_article']);

// On initialise plusieurs variable pour affiché des messages d'erreur quand le formulaire est mal rempli
$nameMessage = '';
$marqueMessage = '';
$categorieMessage = '';
$priceMessage = '';
$descriptionMessage = '';
$acces = true;

// On vérifie SI la super global POST est vide
// SI ce n'est pas le cas alors on commence nos conditions de vérification du formulaire
if ($_POST) {

    // On vérifie que le champ nom ne soit pas vide empty()
    if (empty($_POST["name"])) {
        $acces = false;
        $nameMessage = "<p class='text-danger'>Le champ nom est obligatoire.</p>";
    }

    // On vérifie qu'une catégorie soit choisi
    if ($_POST["categorie"] == 0) {
        $acces = false;
        $categorieMessage = "<p class='text-danger'>Une catégorie doit être choisi.</p>";
    }

    // On vérifie qu'une marque soit choisi
    if ($_POST["marque"] == 0) {
        $acces = false;
        $marqueMessage = "<p class='text-danger'>Une marque doit être choisi.</p>";
    }

    // On vérifie que le champ prix ne soit pas vide empty()
    if (empty($_POST["price"])) {
        $acces = false;
        $priceMessage = "<p class='text-danger'>Le champ prix est obligatoire.</p>";
    }

    // On vérifie que le champ prix soit une valeur numérique et qu'il soit supérieur à zéro
    if (!is_numeric($_POST["price"]) || $_POST["price"] < 0) {
        $acces = false;
        $priceMessage = "<p class='text-danger'>Le champ prix doit contenir un nombre supérieur à zéro.</p>";
    }

    // Si après toutes les vérifications du formulaire $acces est toujours TRUE
    if ($acces) {

        // On créé un nouvelle article en base de données
        updateArticle($pdo, $_GET['id_article'], $_POST["name"], $_POST["categorie"], $_POST["marque"], $_POST["price"], $_POST["description"]);

    }

}

$categories = getCategories($pdo);
$marques = getMarques($pdo);

include ('init/_header.php');
?>

<h2 class="w-100 mx-auto text-center p-4">Modifier un article</h2>

<form class="w-75 p-4 m-4 mx-auto shadow" action="" method="POST">

    <label class="form-label m-2" for="name">Nom* :</label>
    <input class="form-control " type="text" id="name" name="name" value=<?= $article['name']; ?>>
    <?= $nameMessage; ?>

    <label class="form-label m-2" for="categorie">Catégorie* :</label>
    <select class="form-select" id="categorie" name="categorie">
        <option value="0" selected>...</option>
        <?php foreach ($categories as $categorie) { ?>
            <option value=<?= $categorie['id_categorie']; ?>><?= $categorie['name']; ?></option>
        <?php } ?>
    </select>
    <?= $categorieMessage; ?>

    <label class="form-label m-2" for="marque">Marque* :</label>
    <select class="form-select" id="marque" name="marque">
        <option value="0" selected>...</option>
        <?php foreach ($marques as $marque) { ?>
            <option value=<?= $marque['id_marque']; ?>><?= $marque['name']; ?></option>
        <?php } ?>
    </select>
    <?= $marqueMessage; ?>

    <label class="form-label m-2" for="price">Prix* :</label>
    <input class="form-control" type="number" id="price" step="0.01" name="price" min="1"
        value=<?= $article['price']; ?>>
    <?= $priceMessage; ?>

    <label class="form-label m-2" for="description">Description :</label>
    <textarea class="form-control" name="description" id="description" cols="30" rows="10" placeholder="<?= ($article['description'] == null) ? "Pas de description pour le moment." : ""; ?>"><?= ($article['description'] != null) ? $article['description'] : ""; ?></textarea>
    <?= $descriptionMessage; ?>

    <input class="btn bg-success text-white text-center w-100 mt-4" type="submit" value="MODIFIER">

</form>


<?php
include ('init/_footer.php');
?>