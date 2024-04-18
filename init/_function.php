<?php
include ("init/_init.php");

###########################################################################
###########################################################################
##########################                    #############################
##########################   FONCTIONS USERS  #############################
##########################                    #############################
###########################################################################
###########################################################################

// Permet d'inscrire un nouvelle utilisateur en base de données
function createUser(object $pdo, string $login, string $email, string $password): void
{

    $pdoStatement = $pdo->prepare("INSERT INTO user (role, login, email, password, date_create) VALUES (?, ?, ?, ?, ?)");
    // password_hash() permet de créé une clé de hachage pour un mot de passe
    // date() permet de retourne une date sous forme d'une chaîne, au format donné par le paramètre format
    $pdoStatement->execute(['user', $login, $email, password_hash($password, PASSWORD_DEFAULT), date('Y-m-d H:i:s')]);

    // On stock le pseudo et l'adresse email de l'utilisateur dans la super global SESSION, ce qui nous permettera de vérifier s'il est bien connecté sur toute nos pages
    $_SESSION['user'] = [
        "login" => $login,
        "email" => $email,
        "role" => 'user',
    ];

    // redirection
    header('Location: index.php');

}

// Permet de supprimé un utilisateur de la base de données
function deleteUser(object $pdo, string $login): void
{
    $pdoStatement = $pdo->prepare("DELETE FROM user WHERE login = ?");
    $pdoStatement->execute([$login]);

    // redirection
    header('Location: admin_users.php');

}

// Permet de se connecter et de stocker les infos de connection dans la super global SESSION
function signIn(object $pdo, string $login, string $password): void
{

    // On selectionne dans la table user toute les entrées qui possède le pseudo 
    $pdoStatement = $pdo->prepare("SELECT * FROM user WHERE login = ?");
    $pdoStatement->execute([$login]);
    $response = $pdoStatement->fetch();

    // On stock le pseudo et l'adresse email de l'utilisateur dans la super global SESSION, ce qui nous permettera de vérifier s'il est bien connecté sur toute nos pages
    $_SESSION['user'] = [
        "login" => $response['login'],
        "email" => $response['email'],
        "role" => $response['role'],
    ];

    // redirection
    header('Location: index.php');

}

// Permet de récuper tout les utilisateurs en base de données
function getUsers(object $pdo): array
{

    // On selectionne dans la table user toute les entrées
    $pdoStatement = $pdo->prepare("SELECT * FROM user");
    $pdoStatement->execute();
    $response = $pdoStatement->fetchAll();

    return $response;

}

// Permet de vérifier si un pseudo existe en base de donnée
function findUserLogin(object $pdo, string $login): bool
{
    // Initialisation d'un variable booleen
    $check = false;

    // On selectionne dans la table user toute les entrées qui possède le pseudo
    $pdoStatement = $pdo->prepare("SELECT * FROM user WHERE login = ?");
    $pdoStatement->execute([$login]);
    // On compte le nombre de ligne possèdent ce pseudo
    $response = $pdoStatement->rowCount();

    // SI rowCount() renvoi un resultat supérieur a zéro
    if ($response > 0) {
        // Alors oui au moins une entrée avec ce pseudo existe
        $check = true;
    }

    // On retour le booleen
    return $check;
}

// Permet de vérifier si une adresse email existe en base de donnée
function findUserEmail(object $pdo, string $email): bool
{
    // Initialisation d'un variable booleen
    $check = false;

    // On selectionne dans la table user toute les entrées qui possède cette adresse email
    $pdoStatement = $pdo->prepare("SELECT * FROM user WHERE email = ?");
    $pdoStatement->execute([$email]);
    // On compte le nombre de ligne possèdent cette adresse email
    $response = $pdoStatement->rowCount();

    // SI rowCount() renvoi un resultat supérieur a zéro
    if ($response > 0) {
        // Alors oui au moins une entrée avec cette adresse email existe
        $check = true;
    }

    // On retour le booleen
    return $check;
}

// Permet de vérifier si le mot de passe de connexion correspond avec celui du compte choisi
function checkPassword(object $pdo, string $login, string $password): bool
{
    $check = false;

    // On selectionne dans la table user toute les entrées qui possède le pseudo 
    $pdoStatement = $pdo->prepare("SELECT * FROM user WHERE login = ?");
    $pdoStatement->execute([$login]);
    $response = $pdoStatement->fetch();

    // On vérifie si le mot de passe entrée est identique avec celui en base de données
    if (isset($response['password'])) {
        if (password_verify($password, $response['password'])) {
            // SI oui alors passe le booleen sur true
            $check = true;
        }
    }


    return $check;
}

// Permet de connaitre le role d'un utilisateur
function getRole(object $pdo, string $login): string
{
    $role = "user";
    // On selectionne dans la table user toute les entrées qui possède le pseudo 
    $pdoStatement = $pdo->prepare("SELECT * FROM user WHERE login = ?");
    $pdoStatement->execute([$login]);
    $response = $pdoStatement->fetch();

    if (isset($response["role"])) {
        $role = $response["role"];
    }

    return $role;
}

// Permet de connaitre le nombre d'utilisateurs en base de données
function countUser(object $pdo): int
{
    // On selectionne dans la table user toute les entrées
    $pdoStatement = $pdo->prepare("SELECT * FROM user");
    $pdoStatement->execute();
    // On compte le nombre de ligne
    $response = $pdoStatement->rowCount();

    return $response;
}

// Permet de modifier les informations de l'utilisateur de la base de données

###########################################################################
###########################################################################
#########################                        ##########################
#########################   FONCTIONS CATEGORIE  ##########################
#########################                        ##########################
###########################################################################
###########################################################################


// Permet de récuperé toute les catégories en base de données
function getCategories(object $pdo): array
{

    // On selectionne dans la table catégorie toute les entrées
    $pdoStatement = $pdo->prepare("SELECT * FROM categorie ORDER BY name");
    $pdoStatement->execute();
    $response = $pdoStatement->fetchAll();

    return $response;

}

// Permet de récuperé une catégorie en base de données avec l'ID
function getCategorie(object $pdo, int $id_categorie): array
{

    // On selectionne dans la table catégorie l'entrée lié à l'ID
    $pdoStatement = $pdo->prepare("SELECT * FROM categorie WHERE id_categorie = ?");
    $pdoStatement->execute([$id_categorie]);
    $response = $pdoStatement->fetch();

    return $response;

}

// Permet de connaitre le nombre de catégorie en base de données
function countCategorie(object $pdo): int
{
    // On selectionne dans la table catégorie toute les entrées
    $pdoStatement = $pdo->prepare("SELECT * FROM categorie");
    $pdoStatement->execute();
    // On compte le nombre de ligne
    $response = $pdoStatement->rowCount();

    return $response;
}


###########################################################################
###########################################################################
#########################                        ##########################
#########################   FONCTIONS MARQUE     ##########################
#########################                        ##########################
###########################################################################
###########################################################################

// Permet de récuperé toute les marques en base de données
function getMarques(object $pdo): array
{

    // On selectionne dans la table marque toute les entrées
    $pdoStatement = $pdo->prepare("SELECT * FROM marque ORDER BY name");
    $pdoStatement->execute();
    $response = $pdoStatement->fetchAll();

    return $response;

}

// Permet de récuperé une marque en base de données avec l'ID
function getMarque(object $pdo, int $id_marque): array
{

    // On selectionne dans la table marque l'entrée lié à l'ID
    $pdoStatement = $pdo->prepare("SELECT * FROM marque WHERE id_marque = ?");
    $pdoStatement->execute([$id_marque]);
    $response = $pdoStatement->fetch();

    return $response;

}

// Permet de connaitre le nombre de marque en base de données
function countMarque(object $pdo): int
{
    // On selectionne dans la table marque toute les entrées
    $pdoStatement = $pdo->prepare("SELECT * FROM marque");
    $pdoStatement->execute();
    // On compte le nombre de ligne
    $response = $pdoStatement->rowCount();

    return $response;
}

###########################################################################
###########################################################################
#########################                        ##########################
#########################   FONCTIONS ARTICLE    ##########################
#########################                        ##########################
###########################################################################
###########################################################################

// Permet d'ajouter un nouvelle article en base de données
function createArticle(object $pdo, string $name, int $id_categorie, int $id_marque, float $price, string $description = null): void
{
    $pdoStatement = $pdo->prepare("INSERT INTO article (name, id_categorie, id_marque, price, description) VALUES (?, ?, ?, ?, ?)");
    $pdoStatement->execute([$name, $id_categorie, $id_marque, $price, $description]);

    // redirection
    header('Location: admin_articles.php'); 
}

// Permet de modifier un article en base de données
function updateArticle(object $pdo, string $id_article, string $name, int $id_categorie, int $id_marque, float $price, string $description = null): void
{

    $pdoStatement = $pdo->prepare("UPDATE article SET name = ?, id_categorie = ?, id_marque = ?, price = ?, description = ? WHERE id_article = ?");
    $pdoStatement->execute([$name, $id_categorie, $id_marque, $price, $description, $id_article]);

    // redirection
    header('Location: admin_articles.php'); 

}

// Permet de supprimé un article de la base de données
function deleteArticle(object $pdo, int $id_article): void
{
    $pdoStatement = $pdo->prepare("DELETE FROM article WHERE id_article = ?");
    $pdoStatement->execute([$id_article]);

    // redirection
    header('Location: admin_articles.php');

}

// Permet de récuperé tout les articles en base de données
function getArticles(object $pdo): array
{

    // On selectionne dans la table article toute les entrées
    $pdoStatement = $pdo->prepare("SELECT * FROM article ORDER BY id_article DESC");
    $pdoStatement->execute();
    $response = $pdoStatement->fetchAll();

    return $response;

}

// Permet de récuperé un article en base de données avec l'ID
function getArticle(object $pdo, int $id_article): array
{

    // On selectionne dans la table article toute les entrées
    $pdoStatement = $pdo->prepare("SELECT * FROM article WHERE id_article = ?");
    $pdoStatement->execute([$id_article]);
    $response = $pdoStatement->fetch();

    return $response;

}

// Permet de vérifier si un article existe en base de donnée
function findArticle(object $pdo, int $id): bool
{
    // Initialisation d'un variable booleen
    $check = false;

    // On selectionne dans la table article toute les entrées qui possède l'id
    $pdoStatement = $pdo->prepare("SELECT * FROM article WHERE id_article = ?");
    $pdoStatement->execute([$id]);
    // On compte le nombre de ligne possèdent ce pseudo
    $response = $pdoStatement->rowCount();

    // SI rowCount() renvoi un resultat supérieur a zéro
    if ($response > 0) {
        // Alors oui au moins une entrée avec ce pseudo existe
        $check = true;
    }

    // On retour le booleen
    return $check;
}

// Permet de connaitre le nombre d'articles en base de données
function countArticle(object $pdo): int
{
    // On selectionne dans la table user toute les entrées
    $pdoStatement = $pdo->prepare("SELECT * FROM article");
    $pdoStatement->execute();
    // On compte le nombre de ligne
    $response = $pdoStatement->rowCount();

    return $response;
}

?>