<?php ob_start(); ?>
<div class="container mt-5 text-center">
<?php if($_SESSION['permission'] < 1 && $_SESSION['uid'] != $_GET['uid']) : ?>
    <h1>Nincs jogosultságod a profil módosításához!</h1>
<?php else: ?>
  <?php
    require_once PROTECTED_DIR.'functions.php';
    require_once DATABASE_CONTROLLER;

    $query = "SELECT id, first_name, last_name, email, password FROM users WHERE id=:id";
    $params = [
        ':id' => $_GET['uid']
    ];
    $userDetails = getRecord($query,$params);

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updateUser'])){

      $errors=[];

      if(empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['email']) || empty($_POST['email1']) || empty($_POST['password']) || empty($_POST['password1'])){
        $errors['general'][] = "Hiányzó adat(ok)!";
      }
      if($_POST['email'] != $_POST['email1']){
        $errors['email'][] = "Az email címek nem egyeznek!";
      }
      if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $errors['email'][] = "Hibás email formátum!";
      }
      if($_POST['password'] != $_POST['password1']){
        $errors['password'][] = "A jelszavak nem egyeznek!";
      }
      if(strlen($_POST['password']) < 6){
        $errors['password'][] = "A jelszó túl rövid! Legalább 6 karakter hosszúnak kell lennie!";
      }

        if(count($errors) == 0){
            $postData = [
                'id' => $_GET['uid'],
                'fname' => $_POST['first_name'],
                'lname' => $_POST['last_name'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
            ];
        }

        if(count($errors) == 0 && updateUser($postData['id'], $postData['fname'],$postData['lname'], $postData['email'],$postData['password'])){
            header('Location: index.php?P=profile&uid='.$_GET['uid'].'&successful_user_update=1');
            ob_end_flush();
        }

      $postData['password'] = "";
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
  <h1 class="h3 mb-3 text-center font-weight-normal">Profil szerkesztése</h1>
      <div class="form-row">
          <div class="form-group col-md-6">
          <label>Vezetéknév</label>
          <input type="text" class="form-control" id="registerFirstName" name="first_name" value="<?=isset($userDetails) ? $userDetails['first_name'] : "";?>">
          </div>
      <div class="form-group col-md-6">
          <label for="registerLastName">Keresztnév</label>
          <input type="text" class="form-control" id="registerLastName" name="last_name" value="<?=isset($userDetails) ? $userDetails['last_name'] : "";?>">
          </div>
      </div>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="registerEmail">Email</label>
        <input type="email" class="form-control <?php echo isset($errors['email']) ? 'border border-danger' : ''; ?>" id="registerEmail" name="email" value="<?=isset($userDetails) ? $userDetails['email'] : "";?>">
        <small class="text-danger"><?php echo DisplayError('email'); ?></small>
      </div>
    <div class="form-group col-md-6">
        <label for="registerEmail1">Email újra</label>
        <input type="email" class="form-control" id="registerEmail1" name="email1" value="<?=isset($userDetails) ? $userDetails['email'] : "";?>">
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
      <button class="btn btn-lg btn-primary mb-3 w-50" type="submit" name="updateUser">Adatok módosítása</button>
    </div>
  </form>
  </div>

<?php endif; ?>