<?php
  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])){
    $postData = [
      'email' => $_POST['email'],
      'password' => $_POST['password']
    ];

    if(empty($postData['email']) || empty($postData['password'])){
      echo "Hiányzó adat(ok)!";
    } else if(!filter_var($postData['email'], FILTER_VALIDATE_EMAIL)){
      echo "Hibás email formátum!";
    } else if(!UserLogin($postData['email'], $postData['password'])){
      echo "Hibás email cím vagy jelszó!";
    }

    $postData['password'] = "";
  }
?>


<div class="container login-container" style="background-color: white;">
  <div class="login-form">
    <form class="form-signin">
      <h1 class="h3 mb-3 text-center font-weight-normal">Bejelentkezés</h1>
        <label for="inputEmail" class="sr-only" name="email">Email</label>
          <input type="email" id="inputEmail" class="form-control mb-4" placeholder="Felhasználónév" required autofocus>
        <label for="inputPassword" class="sr-only" name="password">Jelszó</label>
          <input type="password" id="inputPassword" class="form-control" placeholder="Jelszó" required>
      <div class="checkbox mb-4">
          <label>
            <input type="checkbox" value="remember-me"> Felhasználónév megjegyzése
          </label>
        </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Bejelentkezés</button>
      </form>
  </div>
</div>