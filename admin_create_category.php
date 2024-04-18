<?php
include ('init/_function.php');

// On controle que l'utilisateur possède le role 'admin'
// SI il ne possède pas le role admin alors on le redirige vers index.php
if (getRole($pdo, $_SESSION['user']['login']) != 'admin') {
    header('Location: index.php');
}

// On initialise plusieurs variable pour affiché des messages d'erreur quand le formulaire est mal rempli
$nameMessage = '';
$acces = true;

// On vérifie SI la super global POST est vide
// SI ce n'est pas le cas alors on commence nos conditions de vérification du formulaire
if ($_POST) {

    // On vérifie que le champ nom ne soit pas vide empty()
    if (empty($_POST["name"])) {
        $acces = false;
        $nameMessage = "<p class='text-danger'>Le champ nom est obligatoire.</p>";
    }

    // On vérifie que le nom de la catégorie ne soit pas utilisé
    if (findCategoryName($pdo, $_POST["name"])){
        $acces = false;
        $nameMessage = "<p class='text-danger'>Ce nom de catégorie existe.</p>";
    }

    // Si après toutes les vérifications du formulaire $acces est toujours TRUE
    if ($acces) {

        // On créé un nouvelle article en base de données
        createCategory($pdo, $_POST["name"]);

    }

}

include ('init/_header.php');
?>

<h2 class="w-100 mx-auto text-center p-4">Ajouter un nouvelle catégorie</h2>

<form class="w-75 p-4 m-4 mx-auto shadow" action="" method="POST">

    <label class="form-label m-2" for="name">Nom* :</label>
    <input class="form-control " type="text" id="name" name="name">
    <?= $nameMessage; ?>

    <input class="btn bg-success text-white text-center w-100 mt-4" type="submit" value="AJOUTER">

</form>

<?php
include ('init/_footer.php');
?>