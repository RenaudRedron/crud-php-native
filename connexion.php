<?php
include ('init/_function.php');

// On initialise plusieurs variable pour affiché des messages d'erreur quand le formulaire est mal rempli
$loginMessage = '';
$passwordMessage = '';
$acces = true;

// On vérifie SI la super global POST est vide
// SI ce n'est pas le cas alors on commence nos conditions de vérification du formulaire
if ($_POST) {

    // On vérifie que le champ pseudo ne soit pas vide empty()
    if (empty($_POST["login"])) {
        $acces = false;
        $loginMessage = "<p class='text-danger'>Le champ pseudo est obligatoire.</p>";
    }

    // On vérifie que le pseudo existe en base de données
    if (!findUserLogin($pdo, $_POST["login"])) {
        $acces = false;
        $loginMessage = "<p class='text-danger'>Ce compte n'existe pas.</p>";
    }

    // On vérifie que le champ mot de passe ne soit pas vide empty()
    if (empty($_POST["password"])) {
        $acces = false;
        $passwordMessage = "<p class='text-danger'>Les champs mot de passe sont obligatoires.</p>";
    }

    // On vérifie que le mot de passe entrée correspond bien avec celui en base de données
    if (!checkPassword($pdo, $_POST["login"], $_POST["password"])) {
        $acces = false;
        $passwordMessage = "<p class='text-danger'>Mot de passe incorrect.</p>";
    }
    // Si après toutes les vérifications du formulaire $acces est toujours TRUE
    if ($acces) {

        // On ce connecte
        signIn ($pdo, $_POST["login"], $_POST["password"]);

    }
}

include ('init/_header.php');
?>

<h2 class="w-100 mx-auto text-center p-4">Se connecter</h2>

<form class="w-75 p-4 m-4 mx-auto shadow" action="" method="POST">

    <label class="form-label m-2" for="login">Pseudo* :</label>
    <input class="form-control " type="text" id="login" name="login" required>
    <?= $loginMessage; ?>

    <label class="form-label m-2" for="password">Mot de passe* :</label>
    <input class="form-control" type="password" id="password" name="password" required>
    <?= $passwordMessage; ?>

    <input class="btn bg-success text-white text-center w-100 mt-4" type="submit" value="SE CONNECTER">

</form>


<?php
include ('init/_footer.php');
?>