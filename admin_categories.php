<?php
include ('init/_function.php');

// On controle que l'utilisateur possède le role 'admin'
// SI il ne possède pas le role admin alors on le redirige vers index.php
if (getRole($pdo, $_SESSION['user']['login']) != 'admin') {
    header('Location: index.php');
}

// On récupére le nombre de catégorie
$numberCategory = countCategory($pdo);

// On initialise une variable pour le message d'erreur
$categoryMessage = '';


if (isset($_GET['deleteCategoryId'])) {

    // SI la catégorie est utilisé dans un article
    if (usedCategory($pdo, $_GET['deleteCategoryId'])) {
        $categoryMessage = "<p class='text-danger text-center'>Il est impossible de supprimer une catégorie qui est liée à un article.</p>";
    } else {   // SINON la catégorie n'est pas utilisé dans un article 

        // SI la catégorie à supprimer existe en base de données
        if (findCategory($pdo, $_GET['deleteCategoryId'])) {
            deleteCategory($pdo, $_GET['deleteCategoryId']);
        }

    }

}


include ('init/_header.php');
?>

<h2 class="w-100 mx-auto text-center p-4">Catégories (<?= $numberCategory; ?>)</h2>

<div class="w-75 mx-auto text-left m-2">
    <a href="admin_create_category.php"><button class="btn bg-dark text-white">
            Ajouter une catégorie
        </button></a>
</div>

<?= $categoryMessage; ?>

<div class="table-responsive">

    <table class="table table-hover table-striped w-75 mx-auto">
        <thead>
            <tr>
                <th scope="col" class="text-center">ID</th>
                <th scope="col" class="text-center">Nom</th>
                <th scope="col" class="text-center"><img src="public/images/modifier.png" alt="Bouton de modification"
                        width="25px"></th>
                <th scope="col" class="text-center"><img src="public/images/supprimer.png" alt="Bouton de suppression"
                        width="25px"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (getCategories($pdo) as $category) { ?>
                <tr>
                    <th scope="row" class="text-center p-4 align-middle"><?= $category['id_category']; ?></th>
                    <td class="text-center p-4 align-middle"><?= $category['name']; ?></td>
                    <td class="text-center p-4 align-middle"><a
                            href="admin_update_category.php?id_category=<?= $category['id_category'] ?>"><img
                                src="public/images/modifier.png" alt="Bouton de modification" width="25px"></a></td>
                    <td class="text-center p-4 align-middle"><a
                            href="admin_categories.php?deleteCategoryId=<?= $category['id_category'] ?>"><img
                                src="public/images/supprimer.png" alt="Bouton de suppression" width="25px"></a></td>
                </tr>

            <?php } ?>

        </tbody>


    </table>
</div>
<?php
include ('init/_footer.php');
?>