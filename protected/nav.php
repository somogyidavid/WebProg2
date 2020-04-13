<hr>

<a href="index.php">Home</a>
<span>&nbsp; | &nbsp;</span>
<?php if(!IsUserLoggedIn()) : ?>
    <a href="index.php?P=login">Login</a>
    <span>&nbsp; | &nbsp;</span>
    <a href="index.php?P=register">Register</a>
<?php else : ?>

    <a href="index.php?P=test">Permission Test</a>
    <span>&nbsp; | &nbsp;</span>

    <?php if(!isset($_SESSION['permission']) || $_SESSION['permission'] >= 1) : ?>
        <a href="index.php?P=users">User List</a>
        <span>&nbsp; | &nbsp;</span>
        <a href="index.php?P=addWorker">Add worker</a>
        <span>&nbsp; | &nbsp;</span>

    <?php endif; ?>

    <a href="index.php?P=logout">Logout</a>
<?php endif; ?>

<hr>