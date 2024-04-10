<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./kepek/logo.png">
    <link rel="stylesheet" href="./CSS/bejelentkezes.css">
    <title>Bejelentkezés</title>
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
        <!-- Megjelenítjük az admin fület, ha a felhasználó admin jogosultsággal rendelkezik -->
        <li><a href="admin.php">Admin</a></li>
    <?php } ?>
                 <?php } else { ?>
                   <li><a href="bejelentkezes.php">Bejelentkezés</a></li>
                   <li><a href="regisztracio.php">Regisztráció</a></li>
                 <?php } ?>
            </ul>
        </nav>
        <div class="regbejform">
          <form action="./php/bejelentkezes.php" method="POST">
              <div class="container">
                <h1>Bejelentkezés</h1>
                <hr>
                <label for="felhasznalonev"><b>Felhasználónév:</b></label>
                <input type="text" name="felhasznalonev" required>
            
                <label for="jelszo"><b>Jelszó:</b></label>
                <input type="password"  name="jelszo" required>
                
                <hr>
                
                <button type="submit" name="bejelentkezik">Bejelentkezés</button>
                <label>
                  <input type="checkbox" checked="checked" name="remember">Emlékezz rám.
                </label>
              </div><div class="container signin">
                <p>Még nincs fiókja?<a href="regisztracio.html">Regtisztráljon</a>.</p>
              </div>
            </form>
        </div>
        <footer>
          <p>Minden jog fenntartva!</p>
          <p>Szesa Kft</p>
        </footer>
    </main>
</body>
</html>