<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./kepek/logo.png">
    <link rel="stylesheet" href="./CSS/admin.css">
    <title>Admin felület</title>
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
        <div class="adminfunkciok">
            <div class="ujtermek">
                <form action="./php/termekfelvitel.php" method="POST" enctype="multipart/form-data">
                    <h1>Új termék felvétele</h1>
                    <label for="megnevezes">Termék neve:</label><br>
                    <input type="text" id="tname" name="megnevezes"><br><br>
                    <label for="cikkszam">Termék cikkszáma:</label><br>
                    <input type="text" id="tname" name="cikkszam"><br><br>
                    <label for="tkep">Termék képe:</label><br>
                    <input type="file" id="pic" name="kep" accept="image/png, image/jpeg" /><br><br>
                    <label for="ar">Termék ára:</label><br>
                    <input type="text" id="tname" name="ar"><br><br>
                    <input type="submit" value="Termék hozzáadása" name="ujtermek">
                    <input type="reset" value="Mégse">
                  </form> 
            </div>
            <hr>
            <div id="admin">
                <div class="regbejform">
                    <form action="./php/adminregisztracio.php" method="POST">
                        <div class="container">
                          <h1>Új admin regisztrálása</h1>
                          <hr>
                          <label for="vezeteknev"><b>Vezetéknév:</b></label>
                            <input type="text" name="vezeteknev" required>

                            <label for="keresztnev"><b>Keresztnév:</b></label>
                            <input type="text" name="keresztnev" required>

                            <label for="felhasznalonev"><b>Felhasználónév:</b></label>
                            <input type="text" name="felhasznalonev" required>

                          <label for="email"><b>E-mail cím:</b></label>
                          <input type="text" name="email" id="email" required>

                          <label for="jelszo"><b>Jelszó:</b></label>
                          <input type="password" placeholder="" name="jelszo" id="psw" required>
                      
                          <label for="jelszo2"><b>Erősítse meg jelszavát:</b></label>
                          <input type="password" placeholder="" name="jelszo2" id="psw-repeat" required>
                          <hr>
                          <button type="submit" class="registerbtn" name="adminregisztral">Regisztráció</button>
                        </div>
                      </form>
                </div>
            </div>
        </div>
        <footer>
            <p>Minden jog fenntartva!</p>
            <p>Szesa Kft</p>
        </footer>
    </main>
</body>
</html>