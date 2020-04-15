<div class="container mt-5">
<?php
  require_once PROTECTED_DIR.'functions.php';
  if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['successful_register'])){
    DisplaySuccess("regisztráció!");
  }

  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])){
    $postData = [
      'email' => $_POST['email'],
      'password' => $_POST['password']
    ];

    $errors = [];

    if(empty($postData['email']) || empty($postData['password'])){
      $errors['general'][] = "Hiányzó adat(ok)!";
    }
    if(!filter_var($postData['email'], FILTER_VALIDATE_EMAIL)){
      $errors['email'][] = "Hibás email formátum!";
    }
    if(!UserLogin($postData['email'], $postData['password'])){
      $errors['wrongdata'][] = "Hibás email cím vagy jelszó!";
    }

    if(count($errors) == 0)
      header('Location: index.php?P=home&successful_login=1');
    }

    $postData['password'] = "";
?>
  <div class="text-center">
  <?php
    if(isset($errors['general'])){
      echo "<div class='alert alert-danger text-center w-30'>".DisplayError('general')."</div>";
    }
  ?>
  </div>
</div>

<div class="container mt-5 login-container" style="background-color: white;">
  <div class="login-form">
    <form class="form-signin" method="post">
      <h1 class="h3 mb-3 text-center font-weight-normal">Bejelentkezés</h1>
          <input type="email" id="inputEmail" class="form-control mb-4" placeholder="Email" name="email">
          <input type="password" id="inputPassword" class="form-control" placeholder="Jelszó" name="password">
          <small class="text-danger"><?php echo DisplayError('wrongdata'); ?></small>
      <div class="checkbox mb-4">
          <label>
            <input type="checkbox" value="remember-me"> Felhasználónév megjegyzése
          </label>
        </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit" name="login">Bejelentkezés</button>
      </form>
  </div>
</div>