<div class="container text-center">
<?php if(!isset($_SESSION['permission']) || $_SESSION['permission'] < 1) : ?>
    <h1>Nincs jogosultságod a hirdetések kezeléséhez!</h1>
<?php else: ?>
<?php
    $query = "SELECT ad.id, ad.userId, ad.title, det.licencePlate, brands.brand_name, models.model_name, det.contact, users.email FROM advertisements ad INNER JOIN advertisementdetails det ON ad.id=det.advertisementId INNER JOIN brands ON brands.id=det.brand INNER JOIN models ON models.id=det.model INNER JOIN users ON users.id=ad.userId";
    require_once DATABASE_CONTROLLER;
    require_once PROTECTED_DIR.'functions.php';
    $advertisements = getList($query);
?>
    <?php if(count($advertisements) <= 0) : ?>
        <h1>Nem található hirdetés az adatbázisban!</h1>
    <?php else : ?>
        <?php if(array_key_exists('successful_ad_remove',$_GET) && isset($_GET['successful_ad_remove'])) DisplaySuccess("hirdetés törlés!"); ?>
        <div class="container bg-dark text-white mb-4 pb-1"><h1>Hirdetések kezelése</h1></div>
        <table class="table table-striped table-dark">
                    <thead>
                        <tr class="text-center">
                            <th scope="col">ID</th>
                            <th scope="col">Cím</th>
                            <th scope="col">Rendszám</th>
                            <th scope="col">Márka</th>
                            <th scope="col">Modell</th>
                            <th scope="col">Elérhetőség</th>
                            <th scope="col">Email</th>
                            <th scope="col">Szerkesztés</th>
                            <th scope="col">Törlés</th>
                            <th scope="col">Részletek</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach($advertisements as $a) : ?>
                            <tr class="text-center">
                                <th scope="row"><?=$a['id']?></th>
                                <td><?=$a['title']?></td>
                                <td><?=$a['licencePlate']?></td>
                                <td><?=$a['brand_name']?></td>
                                <td><?=$a['model_name']?></td>
                                <td><?=$a['contact']?></td>
                                <td><?=$a['email']?></td>
                                <td><a href="index.php?P=updateAdvertisement&id=<?=$a['id']?>&uid=<?=$a['userId']?>&management=1">&#x270D;</a></td>
                                <td><a href="index.php?P=removeAdvertisement&id=<?=$a['id']?>&uid=<?=$a['userId']?>&management=1" onclick="return confirm('Biztos törlöd?')">&#10006;</a></td>
                                <td><a href="index.php?P=advertisementDetails&id=<?=$a['id']?>&uid=<?=$a['userId']?>&management=1">&#128269;</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
      <?php endif; ?>
<?php endif; ?>
</div>

<!--header("location:javascript://history.go(-1)");-->