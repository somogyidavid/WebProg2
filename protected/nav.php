<hr>

<div class="collapse navbar-collapse" id="myNavbar">
    <ul class="navbar-nav ml-auto">
    <?php if(!IsUserLoggedIn()) : ?>
        <li class="nav-item active">
            <a class="nav-link" href="index.php">Kezdőlap<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php?P=login">Bejelentkezés</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php?P=register">Regisztráció</a>
        </li>
    <?php else : ?>
        <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Menü</a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown01">
                <a class="dropdown-item" href="#">Valami</a>                                                               
                <a class="dropdown-item" href="#">Valami 2</a>
                <a class="dropdown-item" href="#">Valami 3</a>
            </div>
        </li>
    <?php endif; ?>
    </ul>
</div>
