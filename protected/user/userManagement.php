<div class="container text-center">
<?php if(!isset($_SESSION['permission']) || $_SESSION['permission'] < 1) : ?>
    <h1>Nincs jogosultságod a hirdetések kezeléséhez!</h1>
<?php else: ?>
<?php
    require_once DATABASE_CONTROLLER;
    require_once PROTECTED_DIR.'functions.php';

    $query = "SELECT id, first_name, last_name, email, password, permission FROM users";

    $users = getList($query);
?>
    <?php if($_SERVER['REQUEST_METHOD'] == 'GET' && array_key_exists('successful_user_update',$_GET) && IsUserLoggedIn()) DisplaySuccess("felhasználó módosítás!"); ?>
        <?php if(array_key_exists('successful_user_remove',$_GET)) DisplaySuccess("felhasználó törlés!"); ?>
        <div class="container bg-dark text-white mb-4 pb-1"><h1>Felhasználók kezelése</h1></div>
        <table class="table table-striped table-dark">
                    <thead>
                        <tr class="text-center">
                            <th scope="col">ID</th>
                            <th scope="col">Vezetéknév</th>
                            <th scope="col">Keresztnév</th>
                            <th scope="col">Email</th>
                            <th scope="col">Jogosultság</th>
                            <th scope="col">Szerkesztés</th>
                            <th scope="col">Törlés</th>
                            <th scope="col">Részletek</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach($users as $u) : ?>
                            <tr class="text-center">
                                <th scope="row"><?=$u['id']?></th>
                                <td><?=$u['first_name']?></td>
                                <td><?=$u['last_name']?></td>
                                <td><?=$u['email']?></td>
                                <td><?= $u['permission'] < 1 ? "Felhasználó" : "Admin" ?></td>
                                <td><a href="index.php?P=updateUser&uid=<?=$u['id']?>&management=1">&#x270D;</a></td>
                                <td><a href="index.php?P=removeUser&uid=<?=$u['id']?>&management=1">&#10006;</a></td>
                                <td><a href="index.php?P=profile&uid=<?=$u['id']?>&management=1">&#128269;</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
<?php endif; ?>
</div>

<!--header("location:javascript://history.go(-1)");-->