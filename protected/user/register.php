  <div class="container mt-5">
  <?php
    require_once PROTECTED_DIR.'functions.php';
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])){
      $postData = [
        'fname' => $_POST['first_name'],
        'lname' => $_POST['last_name'],
        'email' => $_POST['email'],
        'email1' => $_POST['email1'],
        'password' => $_POST['password'],
        'password1' => $_POST['password1']
      ];

      $errors=[];

      if(empty($postData['fname']) || empty($postData['lname']) || empty($postData['email']) || empty($postData['email1']) || empty($postData['password']) || empty($postData['password1'])){
        $errors['general'][] = "Hiányzó adat(ok)!";
      }
      if($postData['email'] != $postData['email1']){
        $errors['email'][] = "Az email címek nem egyeznek!";
      }
      if(!filter_var($postData['email'], FILTER_VALIDATE_EMAIL)){
        $errors['email'][] = "Hibás email formátum!";
      }
      if($postData['password'] != $postData['password1']){
        $errors['password'][] = "A jelszavak nem egyeznek!";
      }
      if(strlen($postData['password']) < 6){
        $errors['password'][] = "A jelszó túl rövid! Legalább 6 karakter hosszúnak kell lennie!";
      }

        if(count($errors) == 0 && UserRegister($postData['email'], $postData['password'], $postData['fname'], $postData['lname'])){
          header('Location: index.php?P=login&successful_register=1');
        }

      $postData['password'] = $postData['password1'] = "";
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
  <form method="post">
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
        <input type="email" class="form-control <?php echo isset($errors['email']) ? 'border border-danger' : ''; ?>" id="registerEmail" name="email" value="<?=isset($postData) ? $postData['email'] : "";?>">
        <small class="text-danger"><?php echo DisplayError('email'); ?></small>
      </div>
    <div class="form-group col-md-6">
        <label for="registerEmail1">Email újra</label>
        <input type="email" class="form-control" id="registerEmail1" name="email1" value="<?=isset($postData) ? $postData['email1'] : "";?>">
      </div>
    </div>

    <div class="form-row">
    <div class="form-group col-md-6">
        <label for="registerPassword">Jelszó</label>
        <input type="password" class="form-control <?php echo isset($errors['password']) ? 'border border-danger' : ''; ?>" id="registerPassword" name="password" value="">
        <small class="text-danger"><?php echo DisplayError('password'); ?></small>
      </div>
      <div class="form-group col-md-6">
        <label for="registerPassword1">Jelszó újra</label>
        <input type="password" class="form-control" id="registerPassword1" name="password1" value="">
      </div>
    </div>
    <div class="text-center">
      <button class="btn btn-lg btn-primary mb-3 w-50" type="submit" name="register">Regisztráció</button>
    </div>
  </form>
  </div>

