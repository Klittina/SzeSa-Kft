<?php
  session_start();

  // Ha a POST kérés tartalmazza az adatot, akkor mentsük el a session-be
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['termekData'])) {
      $termekData = $_POST['termekData'];
      
      // Ellenőrizzük, hogy a session változó létezik-e, ha nem, akkor hozzunk létre egy üres tömböt
      $_SESSION['kosar'] = isset($_SESSION['kosar']) ? $_SESSION['kosar'] : array();
      
      // Mentsük el az adatot a session tömbbe
      $_SESSION['kosar'][] = json_decode($termekData, true);
      echo('$termekdata');
  }
  echo $_SESSION["kosar"];
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
                   <li><a href="kosar.php">Kosár</a></li>
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
        $termekek_json = file_get_contents('./json/termekek.json');
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
                echo'<img src="./kepek/'. $termek['kep'] .'" alt="" style="width: 40%;">';
                echo '  <p class="cikkszam">Cikkszám: ' . $termek['cikkszam'] . '</p>';
                echo '  <p class="ar">Ár: ' . $termek['ar'] . ' Ft</p>';
                echo '<button class="kosarbarak" data-termek=\'' . json_encode($termek) . '\'>Kosárhoz adás</button>';
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $(".kosarbarak").click(function(){
                var termekData = $(this).data('termek');
                console.log(termekData)
                $.post(window.location.href, {termekData: JSON.stringify(termekData)}, function(response){
                    alert("Termék hozzáadva a kosárhoz!");
                });
            });
        });
    </script>
</body>
</html>
