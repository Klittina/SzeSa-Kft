<?php
session_start();
// Ellenőrizzük, hogy a kosár munkamenet változója létezik-e, ha nem, létrehozzuk
if (!isset($_SESSION['kosar'])) {
    $_SESSION['kosar'] = [];
}
var_dump('kosar');
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./kepek/logo.png">
    <link rel="stylesheet" href="./CSS/kosar.css">
    <title>Kosaram</title>
</head>
<body>
<main>
    <header>
        <img src="./kepek/logo.png" alt="">
    </header>
    <nav>
        <ul class="menu">
            <li><a href="index.php">Főoldal</a></li>
            <?php if (isset($_SESSION["user"])) { ?>
                <li><a href="profil.php">Profilom</a></li>
                <li><a href="kosar.php">Kosár</a></li>
                <li><a href="./php/kijelentkezes.php">Kijelentkezés</a></li>
                <?php if ($_SESSION["user"]["jogosultsag"] == 'a') { ?>
                    <li><a href="admin.php">Admin</a></li>
                <?php } ?>
            <?php } else { ?>
                <li><a href="bejelentkezes.php">Bejelentkezés</a></li>
                <li><a href="regisztracio.php">Regisztráció</a></li>
            <?php } ?>
        </ul>
    </nav>
    <div id="kosar">
        <?php
        if (isset($_SESSION['kosar']) && !empty($_SESSION['kosar'])) {
    echo '<h2>Kosár tartalma:</h2>';
    foreach ($_SESSION['kosar'] as $termek) {
        echo '<div>';
        echo '  <p>Termék neve: ' . $termek['megnevezes'] . '</p>';
        echo '  <p>Ár: ' . $termek['ar'] . ' Ft</p>';
        // További termék részletek kiírása...
        echo '</div>';
    }
} else {
    echo '<p>A kosár üres.</p>';
}
?>
    </div>
    <footer>
        <p>Minden jog fenntartva!</p>
        <p>Szesa Kft</p>
    </footer>
</main>
</body>
</html>
