<?php
    require_once DATABASE_CONTROLLER;
    require_once PROTECTED_DIR.'functions.php';
    $query = "SELECT ad.id, ad.userId, ad.title, det.licencePlate, brands.brand_name, models.model_name, det.vintage, det.price, det.image FROM advertisements ad INNER JOIN advertisementdetails det ON ad.id = det.advertisementId INNER JOIN brands ON det.brand = brands.id INNER JOIN models ON det.model = models.id";
    $advertisements = getList($query);
?>
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
                    <?php if(IsUserLoggedIn()) : ?>
                        <a href="index.php?P=advertisementDetails&id=<?=$advertisements[$i]['id']?>&uid=<?=$advertisements[$i]['userId']?>" class="btn btn-primary">Részletek</a>
                    <?php endif; ?>
                    </div>
                </div>
            </div>

        <?php endfor ; ?>
            </div>
    <?php endif; ?>
