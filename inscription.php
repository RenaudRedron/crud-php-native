<?php
include ('init/_function.php');

// On initialise plusieurs variable pour affiché des messages d'erreur quand le formulaire est mal rempli
$loginMessage = '';
$emailMessage = '';
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

    // On vérifie que le pseudo n'existe pas avec la fonction findUserLogin()
    if (findUserLogin($pdo, $_POST["login"])) {
        $acces = false;
        $loginMessage = "<p class='text-danger'>Ce pseudo est déjà utilisé par un autre utilisateur.</p>";
    }

    // On vérifie que le champ adresse email ne soit pas vide empty()
    if (empty($_POST["email"])) {
        $acces = false;
        $emailMessage = "<p class='text-danger'>Le champ adresse email est obligatoire.</p>";
    }

    // On vérifie que l'adresse email n'existe pas avec la fonction findUserEmail()
    if (findUserEmail($pdo, $_POST["email"])) {
        $acces = false;
        $emailMessage = "<p class='text-danger'>Cette adresse email est déjà utilisé par un autre utilisateur.</p>";
    }

    // On vérifie que l'adresse email respecte le format email @
    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $acces = false;
        $emailMessage = "<p class='text-danger'>Cette adresse email ne possède pas le bon format.</p>";
    }

    // On vérifie que les champs mot de passe ne sont pas vide empty()
    if (empty($_POST["password"]) && empty($_POST["password2"])) {
        $acces = false;
        $passwordMessage = "<p class='text-danger'>Les champs mot de passe sont obligatoires.</p>";
    }

    // On vérifie que les deux mot de passe soit identique
    if ($_POST["password"] !== $_POST["password2"]) {
        $acces = false;
        $passwordMessage = "<p class='text-danger'>Les deux mot de passe sont différents.</p>";
    }

    // Si après toutes les vérifications du formulaire $acces est toujours TRUE
    if ($acces) {

        // On créé un nouvelle utilisateur en base de données
        createUser($pdo, $_POST["login"], $_POST["email"], $_POST["password"]);

    }

}

include ('init/_header.php');
?>


<h2 class="w-100 mx-auto text-center p-4">Inscription</h2>

<form class="w-75 p-4 m-4 mx-auto shadow" action="" method="POST">

    <label class="form-label m-2" for="login">Pseudo* :</label>
    <input class="form-control " type="text" id="login" name="login" >
    <?= $loginMessage; ?>

    <label class="form-label m-2" for="email">Email* :</label>
    <input class="form-control" type="text" id="email" name="email" >
    <?= $emailMessage; ?>

    <label class="form-label m-2" for="password">Mot de passe* :</label>
    <input class="form-control" type="password" id="password" name="password" >
    <?= $passwordMessage; ?>

    <label class="form-label m-2" for="password2">Vérification du mot de passe* :</label>
    <input class="form-control" type="password" id="password2" name="password2" >
    <?= $passwordMessage; ?>

    <input class="btn bg-success text-white text-center w-100 mt-4" type="submit" value="INSCRIPTION">

</form>

<?php
include ('init/_footer.php');
?>