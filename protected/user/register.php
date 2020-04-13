<?php
  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])){
    $postData = [
      'fname' => $_POST['first_name'],
      'lname' => $_POST['last_name'],
      'email' => $_POST['email'],
      'email1' => $_POST['email1'],
      'password' => $_POST['password'],
      'password1' => $_POST['password1']
    ];

    if(empty($postData['fname']) || empty($postData['lname']) || empty($postData['email']) || empty($postData['email1']) || empty($postData['password']) || empty($postData['password1'])){
      echo "Hiányzó adat(ok)!";
    } else if($postData['email'] != $postData['email1']){
      echo "Az email címek nem egyeznek!";
    } else if(!filter_var($postData['email'], FILTER_VALIDATE_EMAIL)){
      echo "Hibás email formátum!";
    } else if($postData['password'] != $postData['password1']){
      echo "A jelszavak nem egyeznek!";
    } else if(strlen($postData['password']) < 6){
      echo "A jelszó túl rövid! Legalább 6 karakter hosszúnak kell lennie!";
    } else if(!UserRegister($postData['email'], $postData['password'], $postData['fname'], $postData['lname'])){
      echo "Sikertelen regisztáció!";
    }

    $postData['password'] = $postData['password1'] = "";
  }
?>

<div class="container register-container" style="background-color: white;">
<form method="post" class="bpadding">
<h1 class="h3 mb-3 text-center font-weight-normal">Regisztráció</h1>
    <div class="form-row">
        <div class="form-group col-md-6">
        <label for="registerFirstName">Vezetéknév</label>
        <input type="text" class="form-control" id="registerFirstName" name="first_name" value="<?=isset($postData) ? $postData['fname'] : "";?>">
        </div>
    <div class="form-group col-md-6">
        <label for="registerLastName">Keresztnév</label>
        <input type="text" class="form-control" id="registerLastName" name="last_name" value="<?=isset($postData) ? $postData['lname'] : "";?>">
        </div>
    </div>

  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="registerEmail">Email</label>
      <input type="email" class="form-control" id="registerEmail" name="email" value="<?=isset($postData) ? $postData['email'] : "";?>">
    </div>
   <div class="form-group col-md-6">
      <label for="registerEmail1">Email újra</label>
      <input type="email" class="form-control" id="registerEmail1" name="email1" value="<?=isset($postData) ? $postData['email1'] : "";?>">
    </div>
  </div>

  <div class="form-row">
  <div class="form-group col-md-6">
      <label for="registerPassword">Jelszó</label>
      <input type="password" class="form-control" id="registerPassword" name="password" value="">
    </div>
    <div class="form-group col-md-6">
      <label for="registerPassword1">Jelszó újra</label>
      <input type="password" class="form-control" id="registerPassword1" name="password1" value="">
    </div>
  </div>
  <button class="btn btn-lg btn-primary btn-block" type="submit">Regisztáció</button>
</form>
</div>
