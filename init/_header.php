<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="public/css/style.css">
</head>

<body class="bg-success">

    <header>
        <nav class="navbar navbar-expand-lg bg-success">
            <div class="container-fluid">
                <a class="navbar-brand link-warning text-white" href="index.php">CRUD</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mb-2 ms-auto">
                        <li class="nav-item">
                            <a class="nav-link link-warning text-white" href="panier.php">Panier</a>
                        </li>
                        <?php if (isset($_SESSION['user'])) { ?>
                            <li class="nav-item">
                                <a class="nav-link link-warning text-white" href="#">Profil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link link-warning text-white" href="deconnexion.php">Se déconnecter</a>
                            </li>
                        <?php } else { ?>
                            <li class="nav-item">
                                <a class="nav-link link-warning text-white" href="inscription.php">Inscription</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link link-warning text-white" href="connexion.php">Se connecter</a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="bg-white p-4">
        <!-- ---------------------------------- -->