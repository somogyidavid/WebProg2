<?php if(!isset($_GET['id']) || empty($_GET['id']) || !isset($_GET['uid']) || empty($_GET['uid'])) header('Location: index.php')?>
<?php if(!isset($_SESSION['permission'])) : ?>
    <div class="container"><h1>Nincs jogosultságod ennek a hirdetésnek a módosításához!</h1></div>
<?php elseif($_SESSION['permission'] < 1 && $_SESSION['uid'] != $_GET['uid']) : ?>
    <div class="container"><h1>Nincs jogosultságod ennek a hirdetésnek a módosításához!</h1></div>
<?php else: ?>
    <?php
        require_once DATABASE_CONTROLLER;
        require_once PROTECTED_DIR.'functions.php';
            $id = $_GET['id'];
            $uid = $_GET['uid'];

            $query = "SELECT ad.id, ad.userId, ad.title, det.licencePlate, brands.brand_name, models.model_name, det.vintage, det.type, det.condition, det.price, det.kilometer, det.fuel, det.engineCapacity, det.color, det.description, det.contact, det.image, det.brand, det.model FROM advertisements ad INNER JOIN advertisementdetails det ON ad.id = det.advertisementId INNER JOIN brands ON det.brand = brands.id INNER JOIN models ON det.model = models.id WHERE ad.id=:id";
            $params = [
                ':id' => $id
            ];
            $details = getRecord($query,$params);
            
            $contact1 = substr($details['contact'],3,2);
            $contact2 = substr($details['contact'],5);
    ?>

    <div class="container mt-5">
    <?php
        require_once 'public/brandConfig.php';
        require_once PROTECTED_DIR.'functions.php';
        require_once 'advertisementManager.php';
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updateAdvertisement'])){

        $errors=[];

        if(empty($_POST['price']) || empty($_POST['kilometer']) || empty($_POST['engineCapacity']) || empty($_POST['description']) || empty($_POST['contact2']) || empty($_POST['title'])){
            $errors['general'][] = "Hiányzó adat(ok)!";
        }
        if(strlen($_POST['title'] > 64) || empty($_POST['title'])){
            $errors['title'][] = "Hibás cím!";
        }
        if($_POST['vintage'] == "Adja meg az évjáratot!"){
            $errors['vintage'][] = "Nem megadott évjárat!";
        }
        if($_POST['type'] == "Válassz kivitelt!"){
            $errors['type'][] = "Hiányzó kivitel!";
        }
        if($_POST['condition'] == "Válassz állapotot!"){
            $errors['condition'][] = "Hiányzó állapot!";
        }
        if($_POST['price'] <= 0){
            $errors['price'][] = "Nem megfelelő ár!";
        }
        if($_POST['kilometer'] < 0 || empty($_POST['kilometer'])){
            $errors['kilometer'][] = "Nem érvényes km!";
        }
        if($_POST['fuel'] == "Válassz üzemanyagot!"){
            $errors['fuel'][] = "Hiányzó üzemanyag!";
        }
        if($_POST['engineCapacity'] <= 0){
            $errors['engineCapacity'][] = "Nem megfelelő hengerűrtartalom!";
        }
        if($_POST['color'] == "Válassz színt!"){
            $errors['color'][] = "Hiányzó szín!";
        }
        if(strlen((string)$_POST['contact2']) != 7 || $_POST['contact1'] == '-'){
            $errors['contact'][] = "Nem megfelelő telefonszám formátum!";
        }
        if(Valid_LicensePlate($_POST['licencePlate']) == 0){
            $errors['licencePlate'][] = "Nem megfelelő rendszám formátum!";
        }

            if(count($errors) == 0){
            $postData = [
                'licencePlate' => $_POST['licencePlate'],
                'title' => $_POST['title'],
                //'brand' => $_POST['brandSelect'],
                //'model' => $_POST['model'],
                'brand' => $_POST['brandSelect'] == 0 ? $details['brand'] : $_POST['brandSelect'],
                'model' => $_POST['brandSelect'] == 0 ? $details['model'] : $_POST['model'],
                'vintage' => $_POST['vintage'],
                'type' => $_POST['type'],
                'condition' => $_POST['condition'],
                'price' => $_POST['price'],
                'kilometer' => $_POST['kilometer'],
                'fuel' => $_POST['fuel'],
                'capacity' => $_POST['engineCapacity'],
                'color' => $_POST['color'],
                'description' => $_POST['description'],
                'contact1' => $_POST['contact1'],
                'contact2' => $_POST['contact2'],
            ];

            $contact = '+36'.$postData['contact1'].$postData['contact2'];

            if(updateAdvertisement($details['id'], $_SESSION['uid'],$postData['title'], $postData['licencePlate'],$postData['brand'],$postData['model'],$postData['vintage'],$postData['type'],$postData['condition'],$postData['price'],$postData['kilometer'],$postData['fuel'],$postData['capacity'],$postData['color'],$postData['description'],$contact)){
                header('Location: index.php?P=advertisementDetails&id='.$details['id'].'&uid='.$details['userId'].'&successful_update=1');
            }
            else{
                DisplayCustomError("Hiba történt a módosítás során!");
            }
        }
        }
    ?>
    <div class="text-center">
    <?php
        if(isset($errors['general'])){
        echo "<div class='alert alert-danger text-center w-30'>".DisplayError('general')."</div>";
        }
    ?>
    </div>
    </div>
        
    <div class="container mt-5 register-container" style="background-color: white;">
    
    <form method="post" enctype="multipart/form-data">
    <h1 class="h3 mb-3 text-center font-weight-bold">Hirdetés módosítása</h1>
        <div class="form-row">
            <div class="form-group col-md-12">
            <label class="font-weight-bold">Hirdetés címe</label>
            <input type="text" class="form-control <?php echo isset($errors['title']) ? 'border border-danger' : ''; ?>" name="title" value="<?= isset($details['title']) ? $details['title'] : ""?>">
            <small class="text-danger"><?php echo DisplayError('title'); ?></small>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-5">
                <label class="font-weight-bold">Márka</label>
                <select class="form-control <?php echo isset($errors['brand']) ? 'border border-danger' : ''; ?>" name="brandSelect" id="sel_brand">
                <option value="0" selected><?=$details['brand_name']?> (Eredeti márka és modell használata)</option>
                <option disabled>-----Új márka választása-----</option>
                    <?php
                        $sql_brand = "SELECT * FROM brands";
                        $brand_data = mysqli_query($con,$sql_brand);
                        while($row = mysqli_fetch_assoc($brand_data) ){
                            $brandid = $row['id'];
                            $brand_name = $row['brand_name'];
                            
                            echo "<option value=".$brandid.">".$brand_name."</option>";
                        }
                    ?>
                </select>
                <small class="text-danger"><?php echo DisplayError('brand'); ?></small>
            </div>
            <div class="form-group col-md-1">
            <label>&nbsp;</label>
            <button type="button" class="btn btn-secondary form-control" data-toggle="tooltip" data-placement="left" title="<?='Jelenlegi márka: '.$details['brand_name']?>">
                    ?
                </button>                
            </div>
            <div class="form-group col-md-1">
            <label>&nbsp;</label>
            <button type="button" class="btn btn-secondary form-control" data-toggle="tooltip" data-placement="right" title="<?='Jelenlegi modell: '.$details['model_name']?>">
                    ?
                </button>                
            </div>
            <div class="form-group col-md-5">
                <label class="font-weight-bold">Modell</label>
                    <select class="form-control" name="model" id="sel_model">
                    <option value="0"><?=$details['model_name']?> (Eredeti modell használata)</option>
                    <?= $_POST['brandSelect'] == 0 ? "<option disabled><----Új modell választásához előbb válasszon márkát!-----</option>" : "" ?>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="font-weight-bold">Évjárat</label>
                <select class="form-control <?php echo isset($errors['vintage']) ? 'border border-danger' : ''; ?>" name="vintage">
                    <option>Adja meg az évjáratot!</option>
                <?php
                for($i=date("Y"); $i > 1979; $i--){
                    if($i == $details['vintage']){
                        echo "<option selected>$i</option>";
                    }
                    else{
                        echo "<option>$i</option>";
                    }
                }                
                ?>
                </select>
                <small class="text-danger"><?php echo DisplayError('vintage'); ?></small>
            </div>
            <div class="form-group col-md-6">
                <label class="font-weight-bold">Kivitel</label>
                    <select class="form-control <?php echo isset($errors['type']) ? 'border border-danger' : ''; ?>" name="type">
                    <option>Válassz kivitelt!</option>
                    <option <?= isset($details['type']) && $details['type'] == "Egyterű" ? "selected" : "" ?>>Egyterű</option>
                    <option <?= isset($details['type']) && $details['type'] == "Ferdehátú" ? "selected" : "" ?>>Ferdehátú</option>
                    <option <?= isset($details['type']) && $details['type'] == "Kisbusz" ? "selected" : "" ?>>Kisbusz</option>
                    <option <?= isset($details['type']) && $details['type'] == "Kombi" ? "selected" : "" ?>>Kombi</option>
                    <option <?= isset($details['type']) && $details['type'] == "Lépcsőshátú" ? "selected" : "" ?>>Lépcsőshátú</option>
                    <option <?= isset($details['type']) && $details['type'] == "Sedan" ? "selected" : "" ?>>Sedan</option>
                </select>
                <small class="text-danger"><?php echo DisplayError('type'); ?></small>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="font-weight-bold">Állapot</label>
                <select class="form-control <?php echo isset($errors['condition']) ? 'border border-danger' : ''; ?>" name="condition">
                    <option>Válassz állapotot!</option>
                    <option <?= isset($details['condition']) && $details['condition'] == "Kitűnő" ? "selected" : "" ?>>Kitűnő</option>
                    <option <?= isset($details['condition']) && $details['condition'] == "Megkímélt" ? "selected" : "" ?>>Megkímélt</option>
                    <option <?= isset($details['condition']) && $details['condition'] == "Újszerű" ? "selected" : "" ?>>Újszerű</option>
                    <option <?= isset($details['condition']) && $details['condition'] == "Sérülésmentes" ? "selected" : "" ?>>Sérülésmentes</option>
                    <option <?= isset($details['condition']) && $details['condition'] == "Sérült" ? "selected" : "" ?>>Sérült</option>
                    <option <?= isset($details['condition']) && $details['condition'] == "Hiányos" ? "selected" : "" ?>>Hiányos</option>
                </select>
                <small class="text-danger"><?php echo DisplayError('condition'); ?></small>
            </div>
            <div class="form-group col-md-6">
            <label class="font-weight-bold">Vételár</label>
            <div class="input-group-append">
            <input type="text" class="form-control <?php echo isset($errors['price']) ? 'border border-danger' : ''; ?>" name="price" value="<?=isset($details['price']) ? $details['price'] : "";?>">
            <span class="input-group-text">Ft</span>
            </div>

            <small class="text-danger"><?php echo DisplayError('price'); ?></small>
        </div>
        </div>

        <div class="form-row">
        <div class="form-group col-md-6">
            <label class="font-weight-bold">Km óra állása</label>

            <div class="input-group-append">
            <input type="text" class="form-control <?php echo isset($errors['kilometer']) ? 'border border-danger' : ''; ?>" name="kilometer" value="<?=isset($details['kilometer']) ? $details['kilometer'] : "";?>">
            <span class="input-group-text">km</span>
            </div>

            <small class="text-danger"><?php echo DisplayError('kilometer'); ?></small>
        </div>
            <div class="form-group col-md-6">
                <label class="font-weight-bold">Üzemanyag</label>
                <select class="form-control <?php echo isset($errors['fuel']) ? 'border border-danger' : ''; ?>" name="fuel">
                    <option>Válassz üzemanyagot!</option>
                    <option <?= isset($details['fuel']) && $details['fuel'] == "Benzin" ? "selected" : "" ?>>Benzin</option>
                    <option <?= isset($details['fuel']) && $details['fuel'] == "Dízel" ? "selected" : "" ?>>Dízel</option>
                    <option <?= isset($details['fuel']) && $details['fuel'] == "Benzin/Gáz" ? "selected" : "" ?>>Benzin/Gáz</option>
                    <option <?= isset($details['fuel']) && $details['fuel'] == "Hibrid benzin" ? "selected" : "" ?>>Hibrid benzin</option>
                    <option <?= isset($details['fuel']) && $details['fuel'] == "Hibrid dízel" ? "selected" : "" ?>>Hibrid dízel</option>
                    <option <?= isset($details['fuel']) && $details['fuel'] == "Elektromos" ? "selected" : "" ?>>Elektromos</option>
                </select>
                <small class="text-danger"><?php echo DisplayError('fuel'); ?></small>
            </div>
        </div>

        <div class="form-row">
        <div class="form-group col-md-6">
            <label class="font-weight-bold">Hengerűrtartalom</label>

            <div class="input-group-append">
            <input type="text" class="form-control <?php echo isset($errors['engineCapacity']) ? 'border border-danger' : ''; ?>" name="engineCapacity" value="<?=isset($details['engineCapacity']) ? $details['engineCapacity'] : "";?>">
            <span class="input-group-text">cm³</span>
            </div>
            <small class="text-danger"><?php echo DisplayError('engineCapacity'); ?></small>
        </div>
            <div class="form-group col-md-6">
                <label class="font-weight-bold">Szín</label>
                <select class="form-control <?php echo isset($errors['color']) ? 'border border-danger' : ''; ?>" name="color">
                <option>Válassz színt!</option>
                <option <?= isset($details['color']) && $details['color'] == "Fekete" ? "selected" : "" ?>>Fekete</option>
                <option <?= isset($details['color']) && $details['color'] == "Fehér" ? "selected" : "" ?>>Fehér</option>
                <option <?= isset($details['color']) && $details['color'] == "Piros" ? "selected" : "" ?>>Piros</option>
                <option <?= isset($details['color']) && $details['color'] == "Kék" ? "selected" : "" ?>>Kék</option>
                <option <?= isset($details['color']) && $details['color'] == "Zöld" ? "selected" : "" ?>>Zöld</option>
                <option <?= isset($details['color']) && $details['color'] == "Barna" ? "selected" : "" ?>>Barna</option>
                </select>
                <small class="text-danger"><?php echo DisplayError('color'); ?></small>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="font-weight-bold">Rendszám</label>
                <input type="text" class="form-control <?php echo isset($errors['licencePlate']) ? 'border border-danger' : ''; ?>" name="licencePlate" placeholder="ABC-123" value="<?=isset($details['licencePlate']) ? $details['licencePlate'] : "";?>">
                <small class="text-danger"><?php echo DisplayError('licencePlate'); ?></small>
            </div>

            <div class="form-group col-md-1">
                <label class="font-weight-bold">Telefonszám</label>
                <input type="text" class="form-control" value="+36" readonly>
            </div>
            <div class="form-group col-md-1">
                <label>&nbsp;</label>
                <select class="form-control <?php echo isset($errors['contact']) ? 'border border-danger' : ''; ?>" name="contact1">
                    <option>-</option>
                    <option <?= isset($contact1) && $contact1 == 20 ? "selected" : "" ?>>20</option>
                    <option <?= isset($contact1) && $contact1 == 30 ? "selected" : "" ?>>30</option>
                    <option <?= isset($contact1) && $contact1 == 70 ? "selected" : "" ?>>70</option>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label>&nbsp;</label>
                <input type="text" class="form-control <?php echo isset($errors['contact']) ? 'border border-danger' : ''; ?>" name="contact2" value="<?=isset($contact2) ? $contact2 : "";?>" placeholder="1234567">
                <small class="text-danger"><?php echo DisplayError('contact'); ?></small>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
            <label class="font-weight-bold">Egyéb információk / Leírás</label>
            <input type="text" class="form-control" name="description" value="<?=isset($details['description']) ? $details['description'] : "";?>">
            </div>
        </div>

        <!--<div class="form-row">
            <div class="form-group col-md-4">
            <label class="font-weight-bold">Kép feltöltése</label>
            <input type="file" class="form-control-file <?php echo isset($errors['image']) ? 'border border-danger' : ''; ?>" name="image">
            <small class="text-danger"><?php echo DisplayError('image'); ?></small>
            </div>

            <div class="form-group col-md-4">
                <img class="img-thumbnail mb-0 mt-3 border border-dark border-2" src="public/images/<?=$details['image']?>" width=100>
            </div>
            <div class="form-group col-md-4"></div>
        </div>-->

        <div class="text-center">
        <button class="btn btn-lg btn-primary mb-3 w-50" type="submit" name="updateAdvertisement">Hirdetés módosítása</button>
        </div>

        <div class="text-center">
        <a class="btn btn-lg btn-primary mb-3 w-20" href="index.php?P=advertisementDetails&id=<?=$details['id']?>&uid=<?=$details['userId']?>">Mégsem</a>
        </div>

    </form>
    </div>


<?php endif; ?>