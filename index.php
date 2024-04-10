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
            <div>
                <h1 class="nev">HP 15s-fq2005nha</h1>
                <img src="kepek/kep0.jpg" alt="" style="width: 40%;">
                <p class="ar">200.000 Ft</p>
                <button class="kosarbarak">Kosárhoz adás</button>
            </div>
            <div>
                <h1 class="nev">MSI Business NB</h1>
                <img src="kepek/kep6.jpg" alt="" style="width: 40%;">
                <p class="ar">150.000 Ft</p>
                <button class="kosarbarak">Kosárhoz adás</button>
            </div>
            <div>
                <h1 class="nev">Dell Inspiron 3511</h1>
                <img src="kepek/kep17.jpg" alt="" style="width: 40%;">
                <p class="ar">200.000 Ft</p>
                <button class="kosarbarak">Kosárhoz adás</button>
            </div>
            <div>
                <h1 class="nev">HP 250 G8</h1>
                <img src="kepek/kep22.jpg" alt="" style="width: 40%;">
                <p class="ar">300.000 Ft</p>
                <button class="kosarbarak">Kosárhoz adás</button>
            </div>
            <div>
                <h1 class="nev">Dell Inspiron 3521-i3400</h1>
                <img src="kepek/kep28.jpg" alt="" style="width: 40%;">
                <p class="ar">100.000 Ft</p>
                <button class="kosarbarak">Kosárhoz adás</button>
            </div>
            <div>
                <h1 class="nev">Dell XPS 13</h1>
                <img src="kepek/kep32.jpg" alt="" style="width: 40%;">
                <p class="ar">320.000 Ft</p>
                <button class="kosarbarak">Kosárhoz adás</button>
            </div>
            <div>
                <h1 class="nev">Acer Swift 3 SF314-57</h1>
                <img src="kepek/kep37.jpg" alt="" style="width: 40%;">
                <p class="ar">180.000 Ft</p>
                <button class="kosarbarak">Kosárhoz adás</button>
            </div>
            <div>
                <h1 class="nev">LENOVO ThinkPad L15</h1>
                <img src="kepek/kep11.jpg" alt="" style="width: 40%;">
                <p class="ar">400.000 Ft</p>
                <button class="kosarbarak">Kosárhoz adás</button>
            </div>
            <div>
                <h1 class="nev">Lenovo IdeaPad 5 Pro</h1>
                <img src="./kepek/kep36.jpg" alt="" style="width: 40%;">
                <p class="ar">350.000 Ft</p>
                <button class="kosarbarak">Kosárhoz adás</button>
            </div>
            <div>
                <h1 class="nev">Apple MacBook Air M1</h1>
                <img src="./kepek/kep41.jpg" alt="" style="width: 40%;">
                <p class="ar">585.000 Ft</p>
                <button class="kosarbarak">Kosárhoz adás</button>
            </div>
        </article>
        <footer>
            <p>Minden jog fenntartva!</p>
            <p>Szesa Kft</p>
        </footer>
    </main>
</body>
</html>