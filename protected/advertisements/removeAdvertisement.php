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

        if(executeDML($deleteQuery,$param)){
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

            if(executeDML($deleteQuery,$param)) header('Location: index.php');
        }
    ?>
<?php endif; ?>