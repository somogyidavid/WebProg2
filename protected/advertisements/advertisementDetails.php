<div class="container">
<?php
    if(!isset($_GET['id']) || empty($_GET['id']) || !isset($_GET['uid']) || empty($_GET['uid'])) header('Location: index.php');
    require_once DATABASE_CONTROLLER;
    require_once PROTECTED_DIR.'functions.php';

    if($_SERVER['REQUEST_METHOD'] == 'GET' && array_key_exists('successful_update',$_GET) && isset($_GET['successful_update']) && IsUserLoggedIn()){
        DisplaySuccess("módosítás!");
    }

    if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])){
        $id = $_GET['id'];
        $query = "SELECT ad.id, ad.userId, ad.title, det.licencePlate, brands.brand_name, models.model_name, det.vintage, det.type, det.condition, det.price, det.kilometer, det.fuel, det.engineCapacity, det.color, det.description, det.contact, det.image FROM advertisements ad INNER JOIN advertisementdetails det ON ad.id = det.advertisementId INNER JOIN brands ON det.brand = brands.id INNER JOIN models ON det.model = models.id WHERE ad.id=:id";
        $params = [
            ':id' => $id
        ];
        $details = getRecord($query,$params);
    }
?>
</div>

<div class="container bg-white mt-2 pb-0 mt-5 text-center">
    <h1 class="pb-2"><?=$details['title']?></h1>
</div>
<div class="container bg-white mt-0 pt-0 pb-2">
        <div class="row">
            <div class="col-md-6 text-center mt-4">
                <img class="img-thumbnail mb-0 mt-3 border border-dark border-2" src="public/images/<?=$details['image']?>" width=535>
 
                <div class="form-row pt-4">
                    <table class="table table-dark table-striped">
                        <tbody>
                            <tr>
                                <td class="font-weight-bold">Leírás</td>
                            </tr>
                            <tr>
                                <td><?=$details['description']?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6">
                <div class="container mt-4">
                    <table class="table table-dark table-striped">
                        <tbody>
                            <tr>
                            <th scope="row">Márka:</th>
                            <td><?=ucfirst(strtolower($details['brand_name']))?></td>
                            </tr>
                            <tr>
                            <th scope="row">Modell:</th>
                            <td><?=ucfirst(strtolower($details['model_name']))?></td>
                            </tr>
                            <tr>
                            <th scope="row">Évjárat:</th>
                            <td><?=$details['vintage']?></td>
                            </tr>
                            <tr>
                            <th scope="row">Kivitel:</th>
                            <td><?=$details['type']?></td>
                            </tr>
                            <tr>
                            <th scope="row">Állapot:</th>
                            <td><?=$details['condition']?></td>
                            </tr>
                            <tr>
                            <th scope="row">Ár:</th>
                            <td><?=$details['price']?> Ft</td>
                            </tr>
                            <tr>
                            <th scope="row">Kilométeróra állása:</th>
                            <td><?=$details['kilometer']?> km</td>
                            </tr>
                            <tr>
                            <th scope="row">Üzemanyag:</th>
                            <td><?=$details['fuel']?></td>
                            </tr>
                            <tr>
                            <th scope="row">Hengerűrtartalom:</th>
                            <td><?=$details['engineCapacity']?> cm³</td>
                            </tr>
                            <tr>
                            <th scope="row">Szín:</th>
                            <td><?=$details['color']?></td>
                            </tr>
                            <!--<tr>
                            <th scope="row">Leírás:</th>
                            <td><?=$details['description']?></td>
                            </tr>-->
                            <tr>
                            <th scope="row">Elérhetőség:</th>
                            <td><?=$details['contact']?></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="form-row text-center">
                        <div class="form-group col-md-4">
                            <a href="<?= array_key_exists('management',$_GET) && isset($_GET['management']) ? "index.php?P=advertisementManagement" : "index.php" ?>" class="btn btn-dark mt-2">Vissza</a>
                        </div>
                        <?php if($_SESSION['permission'] >= 1 || $_SESSION['uid'] == $_GET['uid']) : ?>
                        <div class="form-group col-md-4">
                            <a href="index.php?P=updateAdvertisement&id=<?=$details['id']?>&uid=<?=$details['userId']?>" class="btn btn-dark mt-2">Szerkesztés</a>
                        </div>
                        <div class="form-group col-md-4">
                            <a href="index.php?P=removeAdvertisement&id=<?=$details['id']?>&uid=<?=$details['userId']?>" class="btn btn-dark mt-2">Törlés</a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
</div>
