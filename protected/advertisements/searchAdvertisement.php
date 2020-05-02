<?php ob_start(); ?>
<div class="container mt-5">
  <?php
    require_once 'public/brandConfig.php';
    require_once PROTECTED_DIR.'functions.php';
    require_once DATABASE_CONTROLLER;
    require_once 'advertisementManager.php';
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['searchAd'])){

      $search_query = "SELECT ad.id, ad.userId, ad.title, det.licencePlate, brands.brand_name, models.model_name, det.vintage, det.price, det.type, det.condition, det.engineCapacity, det.color, det.image FROM advertisements ad INNER JOIN advertisementdetails det ON ad.id = det.advertisementId INNER JOIN brands ON det.brand = brands.id INNER JOIN models ON det.model = models.id ";

      $errors=[];
      $conditions = false;
      $params = [];

      if($_POST['brandSelect'] != -1 || $_POST['minVintage'] != -1 || $_POST['maxVintage'] != -1 || $_POST['type'] != -1 || $_POST['condition'] != -1 || !empty($_POST['minPrice']) || !empty($_POST['maxPrice']) || !empty($_POST['minKilometer']) || !empty($_POST['maxKilometer']) || $_POST['fuel'] != -1 || !empty($_POST['minEngineCapacity']) || !empty($_POST['maxEngineCapacity']) || $_POST['color'] != -1 || !empty($_POST['licencePlate']) || $_POST['brandSelect'] != -1 || $_POST['model'] != -1){
        $search_query.='WHERE ';
        $conditions = true;
      }

      if($_POST['brandSelect'] != -1 && !isset($_POST['modelCheck'])){
        $search_query.='det.brand=:brand AND ';
        $params += [':brand' => $_POST['brandSelect']];
      }
      else if($_POST['brandSelect'] != -1 && isset($_POST['modelCheck'])){
        $search_query.='det.brand=:brand AND det.model=:model AND ';
        $params += [
          ':brand' => $_POST['brandSelect'],
          ':model' => $_POST['model']
        ];
      }

      if($_POST['minVintage'] != -1 && $_POST['maxVintage'] != -1 && $_POST['minVintage'] > $_POST['maxVintage']){
        $errors['vintage'][] = "Nem megfelelő évjárat!";
      }
      else if(isset($_POST['minVintage']) && $_POST['minVintage'] != -1 && $_POST['maxVintage'] == -1){
        $search_query.='det.vintage>=:minVintage AND ';
        $params += [':minVintage' => $_POST['minVintage']];
      }
      else if($_POST['minVintage'] == -1 && isset($_POST['maxVintage']) && $_POST['maxVintage'] != -1){
        $search_query.='det.vintage<=:maxVintage AND ';
        $params += [':maxVintage' => $_POST['maxVintage']];
      }
      else if(isset($_POST['minVintage']) && $_POST['minVintage'] != -1 && isset($_POST['maxVintage']) && $_POST['maxVintage'] != -1){
        $search_query.='det.vintage BETWEEN :minVintage AND :maxVintage AND ';
        $params += [
          ':minVintage' => $_POST['minVintage'],
          ':maxVintage' => $_POST['maxVintage']
        ];
      }

      if($_POST['type'] != -1){
        $search_query.='det.type=:type AND ';
        $params += [':type' => $_POST['type']];
      }

      if($_POST['condition'] != -1){
        $search_query.='det.condition=:condition AND ';
        $params += [':condition' => $_POST['condition']];
      }
      
  
      if(($_POST['minPrice'] > $_POST['maxPrice'] && !empty($_POST['maxPrice'])) || $_POST['minPrice'] < 0 || $_POST['maxPrice'] < 0){
        $errors['price'][] = "Nem megfelelő ár!";
      }
      else if(!empty($_POST['minPrice']) && empty($_POST['maxPrice'])){
        $search_query.='det.price>=:minPrice AND ';
        $params += [':minPrice' => $_POST['minPrice']];
      }
      else if(empty($_POST['minPrice']) && !empty($_POST['maxPrice'])){
        $search_query.='det.price<=:maxPrice AND ';
        $params += [':maxPrice' => $_POST['maxPrice']];
      }
      else if(!empty($_POST['minPrice']) && !empty($_POST['maxPrice'])){
        $search_query.='det.price BETWEEN :minPrice AND :maxPrice AND ';
        $params += [
          ':minPrice' => $_POST['minPrice'],
          ':maxPrice' => $_POST['maxPrice']
        ];
      }

      if(($_POST['minKilometer'] > $_POST['maxKilometer'] && !empty($_POST['maxKilometer'])) || $_POST['minKilometer'] < 0 || $_POST['maxKilometer'] < 0){
        $errors['kilometer'][] = "Nem érvényes km!";
      }
      else if(!empty($_POST['minKilometer']) && empty($_POST['maxKilometer'])){
        $search_query.='det.kilometer>=:minKilometer AND ';
        $params += [':minKilometer' => $_POST['minKilometer']];
      }
      else if(empty($_POST['minKilometer']) && !empty($_POST['maxKilometer'])){
        $search_query.='det.kilometer<=:maxKilometer AND ';
        $params += [':maxKilometer' => $_POST['maxKilometer']];
      }
      else if(!empty($_POST['minKilometer']) && !empty($_POST['maxKilometer'])){
        $search_query.='det.kilometer BETWEEN :minKilometer AND :maxKilometer AND ';
        $params += [
          ':minKilometer' => $_POST['minKilometer'],
          ':maxKilometer' => $_POST['maxKilometer']
        ];
      }

      if($_POST['fuel'] != -1){
        $search_query.='det.fuel=:fuel AND ';
        $params += [':fuel' => $_POST['fuel']];
      }

      if(($_POST['minEngineCapacity'] > $_POST['maxEngineCapacity'] && !empty($_POST['maxEngineCapacity'])) || $_POST['minEngineCapacity'] < 0 || $_POST['maxEngineCapacity'] < 0){
        $errors['engineCapacity'][] = "Nem érvényes hengerűrtartalom!";
      }
      else if(!empty($_POST['minEngineCapacity']) && empty($_POST['maxEngineCapacity'])){
        $search_query.='det.engineCapacity>=:minEngineCapacity AND ';
        $params += [':minEngineCapacity' => $_POST['minEngineCapacity']];
      }
      else if(empty($_POST['minEngineCapacity']) && !empty($_POST['maxEngineCapacity'])){
        $search_query.='det.engineCapacity<=:maxEngineCapacity AND ';
        $params += [':maxEngineCapacity' => $_POST['maxEngineCapacity']];
      }
      else if(!empty($_POST['minEngineCapacity']) && !empty($_POST['maxEngineCapacity'])){
        $search_query.='det.engineCapacity BETWEEN :minEngineCapacity AND :maxEngineCapacity AND ';
        $params += [
          ':minEngineCapacity' => $_POST['minEngineCapacity'],
          ':maxEngineCapacity' => $_POST['maxEngineCapacity']
        ];
      }

      if($_POST['color'] != -1){
        $search_query.='det.color=:color AND ';
        $params += [':color' => $_POST['color']];
      }

      if(isset($_POST['licencePlate']) && Valid_LicensePlate($_POST['licencePlate']) == 0 && !empty($_POST['licencePlate'])){
        $errors['licencePlate'][] = "Nem megfelelő rendszám formátum!";
      }
      else if(!empty($_POST['licencePlate'])){
        $search_query.='det.licencePlate=:licencePlate AND ';
        $params += [':licencePlate' => $_POST['licencePlate']];
      }

      if($conditions){
        $search_query = substr($search_query,0,strlen($search_query)-5);
      }

      if($conditions){
        //die(var_dump($params,$search_query));
        $advertisements = getList($search_query,$params);
      }
      else{
      $advertisements = getList($search_query);
      }
      //echo $search_query;
}

  ?>
  
  <div class="text-center">
  </div>
  </div>

  <div class="container mt-5 register-container" style="background-color: white;">
  
  <form method="post" enctype="multipart/form-data" id="searchForm" action="#span">
  <h1 class="h3 mb-3 text-center font-weight-bold">Hirdetés keresése</h1>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label class="font-weight-bold">Márka</label>
            <select class="form-control <?php echo isset($errors['brand']) ? 'border border-danger' : ''; ?>" name="brandSelect" id="sel_brand">
              <option value="-1" selected>Válassz egy márkát!</option>
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
                <input type="checkbox" name="modelCheck" id="modelCheck" onclick="EnableDisableTextBox(this)" checked value="1">
                <select class="form-control" id="sel_model" name="model">
                  <option value="-1">Válassz egy modellt!</option>
            </select>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-3">
            <label class="font-weight-bold">Évjárat - Minimum -</label>
            <select class="form-control <?php echo isset($errors['vintage']) ? 'border border-danger' : ''; ?>" name="minVintage">
                <option value="-1">Adja meg az évjáratot!</option>
              <?php for($i=date("Y"); $i > 1979; $i--): ?>
                <option><?=$i?></option>
              <?php endfor; ?>
            </select>
            <small class="text-danger"><?php echo DisplayError('vintage'); ?></small>
        </div>
        <div class="form-group col-md-3">
            <label class="font-weight-bold">- Maximum</label>
            <select class="form-control <?php echo isset($errors['vintage']) ? 'border border-danger' : ''; ?>" name="maxVintage">
                <option value="-1">Adja meg az évjáratot!</option>
              <?php for($i=date("Y"); $i > 1979; $i--): ?>
                <option><?=$i?></option>
              <?php endfor; ?>
            </select>
            <small class="text-danger"><?php echo DisplayError('vintage'); ?></small>
        </div>
        <div class="form-group col-md-6">
            <label class="font-weight-bold">Kivitel</label>
                <select class="form-control <?php echo isset($errors['type']) ? 'border border-danger' : ''; ?>" name="type">
                <option value="-1">Válassz kivitelt!</option>
                <option>Egyterű</option>
                <option>Ferdehátú</option>
                <option>Kisbusz</option>
                <option>Kombi</option>
                <option>Lépcsőshátú</option>
                <option>Sedan</option>
            </select>
            <small class="text-danger"><?php echo DisplayError('type'); ?></small>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label class="font-weight-bold">Állapot</label>
            <select class="form-control <?php echo isset($errors['condition']) ? 'border border-danger' : ''; ?>" name="condition">
                <option value="-1">Válassz állapotot!</option>
                <option>Kitűnő</option>
                <option>Megkímélt</option>
                <option>Újszerű</option>
                <option>Sérülésmentes</option>
                <option>Sérült</option>
                <option>Hiányos</option>
            </select>
            <small class="text-danger"><?php echo DisplayError('condition'); ?></small>
        </div>
        <div class="form-group col-md-3">
        <label class="font-weight-bold">Vételár - Minimum </label>
        <div class="input-group-append">
        <input type="text" class="form-control <?php echo isset($errors['price']) ? 'border border-danger' : ''; ?>" name="minPrice">
        <span class="input-group-text">Ft</span>
        </div>

        <small class="text-danger"><?php echo DisplayError('price'); ?></small>
        </div>
        <div class="form-group col-md-3">
            <label class="font-weight-bold">Vételár - Maximum</label>
            <div class="input-group-append">
            <input type="text" class="form-control <?php echo isset($errors['price']) ? 'border border-danger' : ''; ?>" name="maxPrice">
            <span class="input-group-text">Ft</span>
            </div>
        </div>
    </div>

    <div class="form-row">
    <div class="form-group col-md-3">
        <label class="font-weight-bold">Km óra állása - Minimum -</label>

        <div class="input-group-append">
        <input type="text" class="form-control <?php echo isset($errors['kilometer']) ? 'border border-danger' : ''; ?>" name="minKilometer">
        <span class="input-group-text">km</span>
        </div>

        <small class="text-danger"><?php echo DisplayError('kilometer'); ?></small>
      </div>
      <div class="form-group col-md-3">
        <label class="font-weight-bold">- Maximum</label>

        <div class="input-group-append">
        <input type="text" class="form-control <?php echo isset($errors['kilometer']) ? 'border border-danger' : ''; ?>" name="maxKilometer">
        <span class="input-group-text">km</span>
        </div>

        <small class="text-danger"><?php echo DisplayError('kilometer'); ?></small>
      </div>
        <div class="form-group col-md-6">
            <label class="font-weight-bold">Üzemanyag</label>
            <select class="form-control <?php echo isset($errors['fuel']) ? 'border border-danger' : ''; ?>" name="fuel">
                <option value="-1">Válassz üzemanyagot!</option>
                <option>Benzin</option>
                <option>Dízel</option>
                <option>Benzin/Gáz</option>
                <option>Hibrid benzin</option>
                <option>Hibrid dízel</option>
                <option>Elektromos</option>
            </select>
            <small class="text-danger"><?php echo DisplayError('fuel'); ?></small>
        </div>
    </div>

    <div class="form-row">
    <div class="form-group col-md-3">
        <label class="font-weight-bold">Hengerűrtartalom - Minimum -</label>

        <div class="input-group-append">
        <input type="text" class="form-control <?php echo isset($errors['engineCapacity']) ? 'border border-danger' : ''; ?>" name="minEngineCapacity">
        <span class="input-group-text">cm³</span>
        </div>
        <small class="text-danger"><?php echo DisplayError('engineCapacity'); ?></small>
      </div>
      <div class="form-group col-md-3">
        <label class="font-weight-bold">- Maximum</label>

        <div class="input-group-append">
        <input type="text" class="form-control <?php echo isset($errors['engineCapacity']) ? 'border border-danger' : ''; ?>" name="maxEngineCapacity">
        <span class="input-group-text">cm³</span>
        </div>
        <small class="text-danger"><?php echo DisplayError('engineCapacity'); ?></small>
      </div>
        <div class="form-group col-md-6">
            <label class="font-weight-bold">Szín</label>
            <select class="form-control <?php echo isset($errors['color']) ? 'border border-danger' : ''; ?>" name="color">
              <option value="-1">Válassz színt!</option>
              <option>Fekete</option>
              <option>Fehér</option>
              <option>Piros</option>
              <option>Kék</option>
              <option>Zöld</option>
              <option>Barna</option>
            </select>
            <small class="text-danger"><?php echo DisplayError('color'); ?></small>
        </div>
    </div>
    <div class="form-row text-center pl-5 pr-5 pb-4">
            <label class="font-weight-bold">Rendszám</label>
            <input type="text" class="form-control <?php echo isset($errors['licencePlate']) ? 'border border-danger' : ''; ?>" name="licencePlate" placeholder="ABC-123">
            <small class="text-danger"><?php echo DisplayError('licencePlate'); ?></small>
    </div>

    <div class="text-center">
      <button class="btn btn-lg btn-primary mb-3 w-50" type="submit" name="searchAd" id="search">Hirdetés keresése</button>
    </div>
  </form>
  </div>
  
  <span id="span"></span>
  <div class="container text-center">
  <?php if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['searchAd'])) : ?>
    <?php if(count($advertisements) <= 0) : ?>
          <?php DisplayCustomError("Nem található hirdetés az adatbázisban"); ?>
      <?php else : ?>
          <h1 class=" container text-center mb-5 pb-1 bg-white">Hirdetések</h1>
          <div class="form-row">
          <?php for($i=0;$i<count($advertisements);$i++) : 
                if($i % 3 == 0) : ?>
                  </div>
                  <div class="form-row">
              <?php endif; ?>
              <div class="form-group col-md-4">
                  <div class="card mb-5" style="width: 18em;">
                      <img class="card-img-top border" src="public/images/<?=$advertisements[$i]['image']?>" height="200">
                      <hr>
                      <div class="card-body pt-0">
                          <h4 class="card-title"><?=$advertisements[$i]['title']?></h4>
                          <p class="card-text">Márka: <?=ucfirst(strtolower($advertisements[$i]['brand_name']))?></p>
                          <p class="card-text">Model: <?=ucfirst(strtolower($advertisements[$i]['model_name']))?></p>
                          <p class="card-text">Évjárat: <?=ucfirst(strtolower($advertisements[$i]['vintage']))?></p>
                          <p class="card-text">Ár: <?=$advertisements[$i]['price']?> Ft</p>
                          <a href="index.php?P=advertisementDetails&id=<?=$advertisements[$i]['id']?>&uid=<?=$advertisements[$i]['userId']?>" class="btn btn-primary">Részletek</a>
                      </div>
                  </div>
              </div>
          <?php endfor ; ?>
              </div>
      <?php endif; ?>
      <a href="#top" class="btn btn-primary">Vissza az oldal tetejére</a>
 <?php endif; ?>
  </div>
