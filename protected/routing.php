<?php
    if(!array_key_exists('P',$_GET) || empty($_GET['P']))
        $_GET['P'] = 'home';

        switch($_GET['P']){
            case 'home': require_once PROTECTED_DIR.'normal/home.php';break;
            case 'test': require_once PROTECTED_DIR.'normal/permissionTest.php';break;

            case 'addAdvertisement': IsUserLoggedIn() ? require_once PROTECTED_DIR.'advertisements/addAdvertisement.php' : header('Location: index.php'); break;
            case 'advertisementDetails' : IsUserLoggedIn() ? require_once PROTECTED_DIR.'advertisements/advertisementDetails.php' : header('Location: index.php'); break;
            case 'userAdvertisements' : IsUserLoggedIn() ? require_once PROTECTED_DIR.'advertisements/userAdvertisements.php' : header('Location: index.php'); break;
            case 'removeAdvertisement' : IsUserLoggedIn() ? require_once PROTECTED_DIR.'advertisements/removeAdvertisement.php' : header('Location: index.php'); break;
            case 'updateAdvertisement' : IsUserLoggedIn() ? require_once PROTECTED_DIR.'advertisements/updateAdvertisement.php' : header('Location: index.php'); break;

            case 'login': !IsUserLoggedIn() ? require_once PROTECTED_DIR.'user/login.php' : header('Location: index.php'); break;
            case 'register': !IsUserLoggedIn() ? require_once PROTECTED_DIR.'user/register.php' : header('Location: index.php'); break;
            case 'logout': IsUserLoggedIn() ? UserLogOut() : header('Location: index.php'); break;
            case 'users': IsUserLoggedIn() ? require_once PROTECTED_DIR.'user/userList.php' : header('Location: index.php'); break;

            default: require_once PROTECTED_DIR.'normal/404.php';break;
        }

?>