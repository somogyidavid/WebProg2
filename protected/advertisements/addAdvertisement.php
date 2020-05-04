<?php ob_start(); ?>
<div class="container mt-5">
  <?php
    require_once 'public/brandConfig.php';
    require_once PROTECTED_DIR.'functions.php';
    require_once DATABASE_CONTROLLER;
    require_once 'advertisementManager.php';
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addAdvertisement'])){

      $errors=[];

      if(empty($_POST['price']) || empty($_POST['kilometer']) || empty($_POST['engineCapacity']) || empty($_POST['description']) || empty($_POST['contact2']) || empty($_POST['title'])){
        $errors['general'][] = "Hiányzó adat(ok)!";
      }
      if(strlen($_POST['title'] > 64)){
        $errors['title'][] = "Túl hosszú cím!";
      }
      if($_POST['brandSelect'] == 0){
        $errors['brand'][] = "Hiányzó márka!";
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
      if(empty($_FILES['image']['name'])){
        $errors['image'][] = "Kép feltöltése kötelező!";
      }

        if(count($errors) == 0){
          $temp_filename = explode('.',$_FILES['image']['name']);
          $filename = str_replace('-', '', $_POST['licencePlate']) . '.' . end($temp_filename);
          $postData = [
            'licencePlate' => $_POST['licencePlate'],
            'title' => $_POST['title'],
            'brand' => $_POST['brandSelect'],
            'model' => $_POST['model'],
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
            'image' => $filename
          ];

          $target = 'public/images/'.$filename;
          $contact = '+36'.$postData['contact1'].$postData['contact2'];

        if(insertAdvertisement($_SESSION['uid'],$postData['title'], $postData['licencePlate'],$postData['brand'],$postData['model'],$postData['vintage'],$postData['type'],$postData['condition'],$postData['price'],$postData['kilometer'],$postData['fuel'],$postData['capacity'],$postData['color'],$postData['description'],$contact,$postData['image'])){
          if(move_uploaded_file($_FILES['image']['tmp_name'],$target)){
            header('Location: index.php?P=home&successful_ad_insert=1');
            ob_end_flush();
          }
          else{
            DisplayCustomError("Sikertelen fájlfeltöltés!");
          }
        }
        else{
          DisplayCustomError("Már létező hirdetés!");
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
  <h1 class="h3 mb-3 text-center font-weight-bold">Új hirdetés feladása</h1>

    <div class="form-row">
        <div class="form-group col-md-12">
          <label class="font-weight-bold">Hirdetés címe</label>
          <input type="text" class="form-control <?php echo isset($errors['title']) ? 'border border-danger' : ''; ?>" name="title" value="<?=isset($_POST['title']) ? $_POST['title'] : "";?>">
          <small class="text-danger"><?php echo DisplayError('title'); ?></small>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label class="font-weight-bold">Márka</label>
            <select class="form-control <?php echo isset($errors['brand']) ? 'border border-danger' : ''; ?>" name="brandSelect" id="sel_brand">
              <option value ="0">Válassz egy márkát!</option>
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
        <div class="form-group col-md-6">
            <label class="font-weight-bold">Modell</label>
                <select class="form-control" name="model" id="sel_model">
                  <option value="0">Válassz egy modellt!</option>
            </select>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label class="font-weight-bold">Évjárat</label>
            <select class="form-control <?php echo isset($errors['vintage']) ? 'border border-danger' : ''; ?>" name="vintage">
                <option>Adja meg az évjáratot!</option>
              <?php for($i=date("Y"); $i > 1979; $i--): ?>
                <option><?=$i?></option>
              <?php endfor; ?>
            </select>
            <small class="text-danger"><?php echo DisplayError('vintage'); ?></small>
        </div>
        <div class="form-group col-md-6">
            <label class="font-weight-bold">Kivitel</label>
                <select class="form-control <?php echo isset($errors['type']) ? 'border border-danger' : ''; ?>" name="type">
                <option>Válassz kivitelt!</option>
                <option <?= isset($_POST['type']) && $_POST['type'] == "Egyterű" ? "selected" : "" ?>>Egyterű</option>
                <option <?= isset($_POST['type']) && $_POST['type'] == "Ferdehátú" ? "selected" : "" ?>>Ferdehátú</option>
                <option <?= isset($_POST['type']) && $_POST['type'] == "Kisbusz" ? "selected" : "" ?>>Kisbusz</option>
                <option <?= isset($_POST['type']) && $_POST['type'] == "Kombi" ? "selected" : "" ?>>Kombi</option>
                <option <?= isset($_POST['type']) && $_POST['type'] == "Lépcsőshátú" ? "selected" : "" ?>>Lépcsőshátú</option>
                <option <?= isset($_POST['type']) && $_POST['type'] == "Sedan" ? "selected" : "" ?>>Sedan</option>
            </select>
            <small class="text-danger"><?php echo DisplayError('type'); ?></small>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label class="font-weight-bold">Állapot</label>
            <select class="form-control <?php echo isset($errors['condition']) ? 'border border-danger' : ''; ?>" name="condition">
                <option>Válassz állapotot!</option>
                <option <?= isset($_POST['condition']) && $_POST['condition'] == "Kitűnő" ? "selected" : "" ?>>Kitűnő</option>
                <option <?= isset($_POST['condition']) && $_POST['condition'] == "Megkímélt" ? "selected" : "" ?>>Megkímélt</option>
                <option <?= isset($_POST['condition']) && $_POST['condition'] == "Újszerű" ? "selected" : "" ?>>Újszerű</option>
                <option <?= isset($_POST['condition']) && $_POST['condition'] == "Sérülésmentes" ? "selected" : "" ?>>Sérülésmentes</option>
                <option <?= isset($_POST['condition']) && $_POST['condition'] == "Sérült" ? "selected" : "" ?>>Sérült</option>
                <option <?= isset($_POST['condition']) && $_POST['condition'] == "Hiányos" ? "selected" : "" ?>>Hiányos</option>
            </select>
            <small class="text-danger"><?php echo DisplayError('condition'); ?></small>
        </div>
        <div class="form-group col-md-6">
        <label class="font-weight-bold">Vételár</label>
        <div class="input-group-append">
        <input type="text" class="form-control <?php echo isset($errors['price']) ? 'border border-danger' : ''; ?>" name="price" value="<?=isset($_POST['price']) ? $_POST['price'] : "";?>">
        <span class="input-group-text">Ft</span>
        </div>

        <small class="text-danger"><?php echo DisplayError('price'); ?></small>
      </div>
    </div>

    <div class="form-row">
    <div class="form-group col-md-6">
        <label class="font-weight-bold">Km óra állása</label>

        <div class="input-group-append">
        <input type="text" class="form-control <?php echo isset($errors['kilometer']) ? 'border border-danger' : ''; ?>" name="kilometer" value="<?=isset($_POST['kilometer']) ? $_POST['kilometer'] : "";?>">
        <span class="input-group-text">km</span>
        </div>

        <small class="text-danger"><?php echo DisplayError('kilometer'); ?></small>
      </div>
        <div class="form-group col-md-6">
            <label class="font-weight-bold">Üzemanyag</label>
            <select class="form-control <?php echo isset($errors['fuel']) ? 'border border-danger' : ''; ?>" name="fuel">
                <option>Válassz üzemanyagot!</option>
                <option <?= isset($_POST['fuel']) && $_POST['fuel'] == "Benzin" ? "selected" : "" ?>>Benzin</option>
                <option <?= isset($_POST['fuel']) && $_POST['fuel'] == "Dízel" ? "selected" : "" ?>>Dízel</option>
                <option <?= isset($_POST['fuel']) && $_POST['fuel'] == "Benzin/Gáz" ? "selected" : "" ?>>Benzin/Gáz</option>
                <option <?= isset($_POST['fuel']) && $_POST['fuel'] == "Hibrid benzin" ? "selected" : "" ?>>Hibrid benzin</option>
                <option <?= isset($_POST['fuel']) && $_POST['fuel'] == "Hibrid dízel" ? "selected" : "" ?>>Hibrid dízel</option>
                <option <?= isset($_POST['fuel']) && $_POST['fuel'] == "Elektromos" ? "selected" : "" ?>>Elektromos</option>
            </select>
            <small class="text-danger"><?php echo DisplayError('fuel'); ?></small>
        </div>
    </div>

    <div class="form-row">
    <div class="form-group col-md-6">
        <label class="font-weight-bold">Hengerűrtartalom</label>

        <div class="input-group-append">
        <input type="text" class="form-control <?php echo isset($errors['engineCapacity']) ? 'border border-danger' : ''; ?>" name="engineCapacity" value="<?=isset($_POST['engineCapacity']) ? $_POST['engineCapacity'] : "";?>">
        <span class="input-group-text">cm³</span>
        </div>
        <small class="text-danger"><?php echo DisplayError('engineCapacity'); ?></small>
      </div>
        <div class="form-group col-md-6">
            <label class="font-weight-bold">Szín</label>
            <select class="form-control <?php echo isset($errors['color']) ? 'border border-danger' : ''; ?>" name="color">
            <option>Válassz színt!</option>
              <option <?= isset($_POST['color']) && $_POST['color'] == "Fekete" ? "selected" : "" ?>>Fekete</option>
              <option <?= isset($_POST['color']) && $_POST['color'] == "Fehér" ? "selected" : "" ?>>Fehér</option>
              <option <?= isset($_POST['color']) && $_POST['color'] == "Piros" ? "selected" : "" ?>>Piros</option>
              <option <?= isset($_POST['color']) && $_POST['color'] == "Kék" ? "selected" : "" ?>>Kék</option>
              <option <?= isset($_POST['color']) && $_POST['color'] == "Zöld" ? "selected" : "" ?>>Zöld</option>
              <option <?= isset($_POST['color']) && $_POST['color'] == "Barna" ? "selected" : "" ?>>Barna</option>
            </select>
            <small class="text-danger"><?php echo DisplayError('color'); ?></small>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label class="font-weight-bold">Rendszám</label>
            <input type="text" class="form-control <?php echo isset($errors['licencePlate']) ? 'border border-danger' : ''; ?>" name="licencePlate" placeholder="ABC-123" value="<?=isset($_POST['licencePlate']) ? $_POST['licencePlate'] : "";?>">
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
                <option <?= isset($_POST['contact1']) && $_POST['contact1'] == 20 ? "selected" : "" ?>>20</option>
                <option <?= isset($_POST['contact1']) && $_POST['contact1'] == 30 ? "selected" : "" ?>>30</option>
                <option <?= isset($_POST['contact1']) && $_POST['contact1'] == 70 ? "selected" : "" ?>>70</option>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label>&nbsp;</label>
            <input type="text" class="form-control <?php echo isset($errors['contact']) ? 'border border-danger' : ''; ?>" name="contact2" value="<?=isset($_POST['contact2']) ? $_POST['contact2'] : "";?>" placeholder="1234567">
            <small class="text-danger"><?php echo DisplayError('contact'); ?></small>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-12">
          <label class="font-weight-bold">Egyéb információk / Leírás</label>
          <input type="text" class="form-control" name="description" value="<?=isset($_POST['description']) ? $_POST['description'] : "";?>">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-12">
          <label class="font-weight-bold">Kép feltöltése</label>
          <input type="file" class="form-control-file <?php echo isset($errors['image']) ? 'border border-danger' : ''; ?>" name="image">
          <small class="text-danger"><?php echo DisplayError('image'); ?></small>
        </div>
    </div>

    <div class="text-center">
      <button class="btn btn-lg btn-primary mb-3 w-50" type="submit" name="addAdvertisement">Hirdetés feladása</button>
    </div>
  </form>
  </div>
