<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beadandó</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/login.css">
</head>
<body style="background-color: #8EA3BF;">
    
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="#">Használt autók</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#myNavbar" aria-controls="myNavbar" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse" id="myNavbar">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="#">Kezdőlap<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Bejelentkezés</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Menü</a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown01">
                <a class="dropdown-item" href="#">Valami</a>                                                               
                <a class="dropdown-item" href="#">Valami 2</a>
                <a class="dropdown-item" href="#">Valami 3</a>
              </div>
            </li>
          </ul>
        </div>
      </nav>

      <div class="container login-container" style="background-color: white;">
            <div class="login-form">
                <form class="form-signin">
                    <h1 class="h3 mb-3 text-center font-weight-normal">Bejelentkezés</h1>
                    <label for="inputEmail" class="sr-only">Felhasználónév</label>
                    <input type="email" id="inputEmail" class="form-control mb-4" placeholder="Felhasználónév" required autofocus>
                    <label for="inputPassword" class="sr-only">Jelszó</label>
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

      <footer class="text-center footer">|- Copyright &copy; 2020 -|</footer>


    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>