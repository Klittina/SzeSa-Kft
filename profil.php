<?php
  session_start();
  echo $_SESSION["kosar"];
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./kepek/logo.png">
    <link rel="stylesheet" href="./CSS/profilom.css">
    <title>Profilom</title>
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
        <!-- Megjelenítjük az admin fület, ha a felhasználó admin jogosultsággal rendelkezik -->
        <li><a href="admin.php">Admin</a></li>
    <?php } ?>
                 <?php } else { ?>
                   <li><a href="bejelentkezes.php">Bejelentkezés</a></li>
                   <li><a href="regisztracio.php">Regisztráció</a></li>
                 <?php } ?>
            </ul>
        </nav>
        <div id="profilom">
            <div id="adataim">
                <form action="/action_page.php">
                    <div class="container">
                      <h1>Adataim</h1>
                      <hr>
                      <label for="vezeteknev"><b>Vezetéknév:</b></label>
                        <input type="text" placeholder="Szedlár" name="uname" required>
                        <label for="keresztnev"><b>Keresztnév:</b></label>
                        <input type="text" placeholder="Krisztina" name="uname" required>
                        <label for="felhasznalonev"><b>Felhasználónév:</b></label>
                        <input type="text" placeholder="Klittina" name="uname" required>
                      <label for="email"><b>E-mail cím:</b></label>
                      <input type="text" placeholder="szedlarkrisztina@gmail.com" name="email" id="email" required>
                  
                      <label for="psw"><b>Új jelszó:</b></label>
                      <input type="password" placeholder="" name="psw" id="psw" required>
                  
                      <label for="psw-repeat"><b>Erősítse meg új jelszavát:</b></label>
                      <input type="password" placeholder="" name="psw-repeat" id="psw-repeat" required>
                      <hr>
                      <button type="submit" class="registerbtn">Frissitem</button>
                    </div>
                  </form>
            </div>
            <hr>
            <div id="korabbirendelesek">
                <h1>Itt jelennek majd meg a korábbi rendelései.</h1>
            </div>
        </div>
        <footer>
            <p>Minden jog fenntartva!</p>
            <p>Szesa Kft</p>
        </footer>
    </main>
</body>
</html>