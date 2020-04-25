<div class="container">
    <?php
        require_once PROTECTED_DIR.'functions.php';
        if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['successful_login']) && IsUserLoggedIn()){
            DisplaySuccess("bejelentkezés!");
        }

        if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['successful_ad_insert']) && IsUserLoggedIn()){
            DisplaySuccess("hirdetésfeladás!");
        }

        require_once PROTECTED_DIR.'advertisements/listAdvertisements.php';
    ?>
</div>