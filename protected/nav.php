<hr>

<div class="collapse navbar-collapse" id="myNavbar">
    <ul class="navbar-nav ml-auto">
    <li class="nav-item active">
            <a class="nav-link" href="index.php?P=home">Kezdőlap<span class="sr-only">(current)</span></a>
    </li>
    <?php if(!IsUserLoggedIn()) : ?>

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
                <a class="dropdown-item" href="#">Hirdetés feladása</a>                                                               
                <a class="dropdown-item" href="#">Saját hirdetéseim</a>
            <?php if(!isset($_SESSION['permission']) || $_SESSION['permission'] >= 1) : ?>
                <a class="dropdown-item" href="#">Hirdetések kezelése</a>
                <a class="dropdown-item" href="#">Profilok kezelése</a>
            <?php endif; ?>
                <a class="dropdown-item" href="#">Work in progress...</a>
            </div>
        </li>
        
        <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Profil</a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown01">
                <a class="dropdown-item" href="#">Saját profil megtekintése</a>                                                               
                <a class="dropdown-item" href="#">Profil szerkesztése</a>
                <a class="dropdown-item" href="#"></a>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="index.php?P=logout">Kijelentkezés</a>
        </li>
        
    <?php endif; ?>
    </ul>
</div>
