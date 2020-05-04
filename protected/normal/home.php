<div class="container">
    <?php
        require_once PROTECTED_DIR.'functions.php';
        if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['successful_login']) && IsUserLoggedIn()){
            DisplaySuccess("bejelentkezés!");
        }

        if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['successful_ad_insert']) && IsUserLoggedIn()){
            DisplaySuccess("hirdetésfeladás!");
        }

        if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['successful_ad_remove']) && IsUserLoggedIn()){
            DisplaySuccess("hirdetés törlés!");
        }

        if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['successful_user_remove'])){
            DisplaySuccess("felhasználó törlés!");
        }

        require_once PROTECTED_DIR.'advertisements/listAdvertisements.php';
    ?>
</div>