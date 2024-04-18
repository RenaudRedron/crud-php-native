<?php
include ('init/_function.php');

// On controle que l'utilisateur possède le role 'admin'
// SI il ne possède pas le role admin alors on le redirige vers index.php
if (getRole($pdo, $_SESSION['user']['login']) != 'admin') {
    header('Location: index.php');
}

$numberUser = countUser($pdo);

if (isset($_GET['deleteUserLogin'])) {

    // SI l'utilisateur à supprimer n'est pas celui actuellement connecté et que le login existe en base de données
    if ($_SESSION['user']['login'] != $_GET['deleteUserLogin'] && findUserLogin($pdo, $_GET['deleteUserLogin'])) {
        deleteUser($pdo, $_GET['deleteUserLogin']);
    }

}

include ('init/_header.php');
?>

<h2 class="w-100 mx-auto text-center p-4">Utilisateurs (<?= $numberUser; ?>)</h2>

<div class="table-responsive">

    <table class="table table-hover table-striped w-75 mx-auto">
        <thead>
            <tr>
                <th scope="col" class="text-center col-3">ID</th>
                <th scope="col" class="text-center col-3">Role</th>
                <th scope="col" class="text-center col-3">Pseudo</th>
                <th scope="col" class="text-center col-3">Email</th>
                <th scope="col" class="text-center col-3">Inscription</th>
                <th scope="col" class="text-center col-3"><img src="public/images/modifier.png"
                        alt="Bouton de modification" width="25px"></th>
                <th scope="col" class="text-center col-3"><img src="public/images/supprimer.png"
                        alt="Bouton de suppression" width="25px"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (getUsers($pdo) as $user) { ?>
                <tr>
                    <th scope="row" class="text-center p-4 col-3 align-middle"><?= $user['id_user']; ?></th>
                    <td class="text-center p-4 col-3 align-middle"><?= $user['role']; ?></td>
                    <td class="text-center p-4 col-3 align-middle"><?= htmlspecialchars($user['login']); ?></td>
                    <td class="text-center p-4 col-3 align-middle"><?= htmlspecialchars($user['email']); ?></td>
                    <td class="text-center p-4 col-3 align-middle"><?= $user['date_create']; ?></td>
                    <td class="text-center p-4 col-3 align-middle"><a href="#"><img src="public/images/modifier.png"
                                alt="Bouton de modification" width="25px"></a></td>
                    <td class="text-center p-4 col-3 align-middle"><a
                            href="admin_users.php?deleteUserLogin=<?= htmlspecialchars($user['login']) ?>"><img
                                src="public/images/supprimer.png" alt="Bouton de suppression" width="25px"></a></td>
                </tr>

            <?php } ?>

        </tbody>


    </table>
</div>
<?php
include ('init/_footer.php');
?>