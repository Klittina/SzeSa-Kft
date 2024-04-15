<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./kepek/logo.png">
    <link rel="stylesheet" href="./CSS/index.css">
    <title>Főoldal</title>
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
                   <li><a href="./php/kijelentkezes.php">Kijelentkezés</a></li>
                   <?php if ($_SESSION["user"]["jogosultsag"] == "a") { ?>
                    <li><a href="admin.php">Admin</a></li>
                 <?php } ?>
                 <?php } else { ?>
                   <li><a href="bejelentkezes.php">Bejelentkezés</a></li>
                   <li><a href="regisztracio.php">Regisztráció</a></li>
                 <?php } ?>
            </ul>
        </nav>
        <article>
        <?php
        // Betöltjük a termékek listáját a JSON fájlból
        $termekek_json = file_get_contents('./php/termekek.json');
        $termekek = json_decode($termekek_json, true);

        // Ellenőrizzük, hogy sikerült-e betölteni az adatokat
        if ($termekek === null) {
            die('Hiba történt az adatok betöltése közben.');
        }

        // Ellenőrizzük, hogy van-e legalább egy termék
        if (empty($termekek['termekek'])) {
            echo 'Nincsenek termékek a listában.';
        } else {
            // Ha vannak termékek, megjelenítjük azokat
            foreach ($termekek['termekek'] as $termek) {
                echo '<div class="termek">';
                echo '  <h1 class="nev">' . $termek['megnevezes'] . '</h1>';
                echo'<img src="'. $termek['kepek']["kep0"] .'" alt="" style="width: 40%;">';
                echo '  <p>Ár: ' . $termek['ar'] . ' Ft</p>';
                echo '<button class="kosarbarak">Kosárhoz adás</button>';
                echo '</div>';
            }
        }
        ?>
        </article>
        <footer>
            <p>Minden jog fenntartva!</p>
            <p>Szesa Kft</p>
        </footer>
    </main>
</body>
</html>