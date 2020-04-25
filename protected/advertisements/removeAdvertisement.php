<?php if(!isset($_GET['id']) || empty($_GET['id'])) header('Location: index.php')?>
<?php if(!isset($_SESSION['permission']) || $_SESSION['permission'] < 1 || ($_SESSION['permission'] < 1 && $_SESSION['uid'] != $_GET['id'])) : ?>
    <h1>Nincs jogosultságod ennek a hirdetésnek a törléséhez.</h1>
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