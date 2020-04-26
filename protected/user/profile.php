<div class="container">
<?php
    require_once DATABASE_CONTROLLER;
    require_once PROTECTED_DIR.'functions.php';

    if($_SERVER['REQUEST_METHOD'] == 'GET' && array_key_exists('successful_user_update',$_GET) && IsUserLoggedIn()){
        DisplaySuccess("módosítás!");
    }

    $query = "SELECT id, first_name, last_name, email, permission FROM users WHERE id=:id";

    if($_SESSION['permission'] < 1){
        $params = [
            ':id' => $_SESSION['uid']
        ];
    }
    else if(array_key_exists('uid',$_GET)){
        $params = [
            ':id' => $_GET['uid']
        ];
    }
    $userDetails = getRecord($query,$params);
?>
</div>

<div class="container bg-dark text-white mt-2 pb-0 mt-5 text-center">
    <h1 class="pb-2">Saját profil</h1>
</div>
<div class="container mt-5 text-center">
        <table class="table table-dark table-striped">
            <tbody>
                <tr>
                <th scope="row">Vezetéknév:</th>
                <td><?=$userDetails['first_name']?></td>
                </tr>
                <tr>
                <th scope="row">Keresztnév:</th>
                <td><?=$userDetails['last_name']?></td>
                </tr>
                <tr>
                <th scope="row">Email:</th>
                <td><?=$userDetails['email']?></td>
                </tr>
                <tr>
                <th scope="row">Jog:</th>
                <td><?= $userDetails['permission'] == 0 ? "Felhasználó" : "Admin" ?></td>
                </tr>
            </tbody>
        </table>
    <div class="row">
    <?php if($_SESSION['permission'] > 0 || $_SESSION['uid'] == $_GET['uid']) : ?>
        <div class="col-md-4">
            <a href="index.php?P=updateUser&uid=<?=$userDetails['id']?>" class="btn btn-dark">Szerkesztés</a>
        </div>
    <?php endif; ?>
        <div class="col-md-<?= $_SESSION['permission'] || $_SESSION['uid'] == $_GET['uid'] > 0 ? "4" : "12" ?>">
            <a href="#" class="btn btn-dark btn-lg">Vissza</a>
        </div>
    <?php if($_SESSION['permission'] > 0 || $_SESSION['uid'] == $_GET['uid']) : ?>
        <div class="col-md-4">
            <a href="index.php?P=removeUser&uid=<?=$userDetails['id']?>" class="btn btn-dark">Törlés</a>
        </div>
    <?php endif; ?>
    </div>
</div>
