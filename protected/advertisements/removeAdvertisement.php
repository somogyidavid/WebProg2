<?php if(!isset($_GET['id']) || empty($_GET['id']) || !isset($_GET['uid']) || empty($_GET['uid'])) header('Location: index.php')?>
<?php if(!isset($_SESSION['permission'])) : ?>
    <div class="container"><h1>Nincs jogosultságod ennek a hirdetésnek a törléséhez!</h1></div>
<?php elseif($_SESSION['permission'] < 1 && $_SESSION['uid'] != $_GET['uid']) : ?>
    <div class="container"><h1>Nincs jogosultságod ennek a hirdetésnek a törléséhez!</h1></div>
<?php else: ?>
    <?php
        require_once DATABASE_CONTROLLER;
        
        $query = "SELECT * from advertisementDetails WHERE advertisementId = :id";
        $param = [
            ':id' => $_GET['id']
        ];
        $advertisementToDelete = getRecord($query,$param);

        if($advertisementToDelete == []) header('Location: index.php');

        $deleteQuery = "DELETE FROM advertisementDetails WHERE advertisementId = :id";
        $param = [
            ':id' => $_GET['id']
        ];

        $deleteImageQuery = "SELECT image FROM advertisementDetails WHERE advertisementId = :id";
        $deleteImageParams = [
            ':id' => $_GET['id']
        ];

        $imageToDelete = getRecord($deleteImageQuery,$deleteImageParams);

        if(executeDML($deleteQuery,$param)){
            $filepath = 'public/images/'.$imageToDelete['image'];

            unlink($filepath);
            $query = "SELECT * FROM advertisements WHERE id=:id";
            $param = [
                ':id' => $_GET['id']
            ];
            $advertisementToDelete = getRecord($query,$param);

            if($advertisementToDelete == []) header('Location: index.php');

            $deleteQuery = "DELETE FROM advertisements WHERE id=:id";
            $param = [
                ':id' => $_GET['id']
            ];

            if(executeDML($deleteQuery,$param)){
                if(array_key_exists('management',$_GET) && isset($_GET['management'])){
                    header('Location: index.php?P=advertisementManagement&successful_ad_remove=1');
                }
                else{
                    header('Location: index.php?P=home&successful_ad_remove=1');
                }
            }
        }
    ?>
<?php endif; ?>