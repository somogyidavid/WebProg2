<?php ob_start(); ?>
<?php if(!isset($_GET['uid'])) header('Location: index.php')?>
<?php if(!isset($_SESSION['permission'])) : ?>
    <div class="container"><h1>Nincs jogosultságod ennek a hirdetésnek a törléséhez!</h1></div>
<?php elseif($_SESSION['permission'] < 1 && $_SESSION['uid'] != $_GET['uid']) : ?>
    <div class="container"><h1>Nincs jogosultságod ennek a hirdetésnek a törléséhez!</h1></div>
<?php else: ?>
    <?php
        require_once DATABASE_CONTROLLER;
        require_once USER_MANAGER;
        
        $query = "SELECT * from users WHERE id = :id";
        $param = [
            ':id' => $_GET['uid']
        ];
        $userToDelete = getRecord($query,$param);

        if($userToDelete == []) header('Location: index.php');

        $deleteQuery = "DELETE FROM users WHERE id = :id";
        $param = [
            ':id' => $_GET['uid']
        ];

        if(executeDML($deleteQuery,$param)){
            if(array_key_exists('management',$_GET)){
                if($_SESSION['permission'] < 1){
                    session_unset();
                    session_destroy();
                    header('Location: index.php?P=home&successful_user_remove=1');
                }
                else{
                    header('Location: index.php?P=userManagement&successful_user_remove=1');
                }

                ob_end_flush();
            }
            else{
                if($_SESSION['permission'] < 1){
                    session_unset();
                    session_destroy();
                    header('Location: index.php?P=home&successful_user_remove=1');
                }
                else{
                    header('Location: index.php?P=userManagement&successful_user_remove=1');
                }

                ob_end_flush();
            }
        }
    ?>
<?php endif; ?>