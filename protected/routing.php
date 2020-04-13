<?php
    if(!array_key_exists('P',$_GET) || empty($_GET['P']))
        $_GET['P'] = 'home';

        switch($_GET['P']){
            case 'home': require_once PROTECTED_DIR.'normal/home.php';break;
            case 'test': require_once PROTECTED_DIR.'normal/permissionTest.php';break;

            case 'addWorker': IsUserLoggedIn() ? require_once PROTECTED_DIR.'worker/add.php' : header('Location: index.php'); break;

            case 'login': !IsUserLoggedIn() ? require_once PROTECTED_DIR.'user/login.php' : header('Location: index.php'); break;
            case 'register': !IsUserLoggedIn() ? require_once PROTECTED_DIR.'user/register.php' : header('Location: index.php'); break;
            case 'logout': IsUserLoggedIn() ? UserLogOut() : header('Location: index.php'); break;
            case 'users': IsUserLoggedIn() ? require_once PROTECTED_DIR.'user/userList.php' : header('Location: index.php'); break;
            default: require_once PROTECTED_DIR.'normal/404.php';break;
        }

?>