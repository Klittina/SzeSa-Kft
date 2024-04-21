<?php
  session_start();
  // Ha nincs bejelentkezve a felhasználó, és az URL-ben nincs beírva a kosar.php, akkor átirányítjuk a bejelentkezési oldalra
if (!isset($_SESSION["user"]) && basename($_SERVER['PHP_SELF']) != 'bejelentkezes.php') {
  header("Location: bejelentkezes.php");
  exit;
}
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
            <div id="container" >
                <div class="adataim" class="float-left">
              <form action="./php/adatmodositas.php" method="POST">
                    <h1>Adataim</h1>
                    <hr>
                    <label for="vezeteknev"><b>Vezetéknév:</b></label>
                    <input type="text"  name="vezeteknev" value="<?php echo $_SESSION['user']['vezeteknev']; ?>" required>
                    <label for="keresztnev"><b>Keresztnév:</b></label>
                    <input type="text" name="keresztnev" value="<?php echo $_SESSION['user']['keresztnev']; ?>" required>
                    <label for="felhasznalonev"><b>Felhasználónév:</b></label>
                    <input type="text" name="felhasznalonev" value="<?php echo $_SESSION['user']['felhasznalonev']; ?>" required>
                    <label for="email"><b>E-mail cím:</b></label>
                    <input type="text" name="email" id="email" value="<?php echo $_SESSION['user']['email']; ?>" required>
                    <label for="psw"><b>Új jelszó:</b></label>
                    <input type="password" placeholder="" name="jelszo" id="psw" required>
                    <label for="psw-repeat"><b>Erősítse meg új jelszavát:</b></label>
                    <input type="password" placeholder="" name="jelszo2" id="psw-repeat" required>
                    <hr>
                    <button type="submit" class="registerbtn" name="frissit">Frissitem</button>
              </form>
                </div>
               <div class="profilkep float-left">
                <h1>Profilkép</h1>
                <br>
                <img src="./kepek/<?php echo $_SESSION['user']['kep'];?>">
                
                <form action="./php/profilkepmodositas.php" method="post" enctype="multipart/form-data">
    <input type="file" name="fileToUpload" id="fileToUpload">
    <button type="submit" name="upload" class="ujprofil">Profilkép feltöltése</button>
</form>
               </div>
            </div>
            <hr>
            <div id="korabbirendelesek">
            <?php
    // Load orders from JSON file
    $ordersData = json_decode(file_get_contents('./json/orders.json'), true);

    // Function to find orders by user ID
    function findOrdersByUserId($orders, $userId) {
        $userOrders = array();
        foreach ($orders['orders'] as $order) {
            if ($order['user_id'] === $userId) {
                $userOrders[] = $order;
            }
        }
        return $userOrders;
    }

    // Get user ID from URL parameter
    $userId = $_SESSION['user']['felhasznalonev'];
    $userOrders = findOrdersByUserId($ordersData, $userId);

    // Generate HTML table
    if (empty($userOrders)) {
        echo "<p>Még nem adott le rendelést. <br> Itt jelennek majd meg a korábbi rendelései.</p>";
    } else {
        echo '<table border="1">';
        echo '<tr><th>Rendelés azonosító</th><th>Termék neve</th><th>Termék ára</th><th>Mennyiség</th><th>Összesen</th></tr>';
        foreach ($userOrders as $order) {
            foreach ($order['items'] as $item) {
                echo "<tr>";
                echo "<td>{$order['id']}</td>";
                echo "<td>{$item['item_name']}</td>";
                echo "<td>{$item['item_price']}</td>";
                echo "<td>{$item['item_quantity']}</td>";
                echo "<td>{$order['total']}</td>";
                echo "</tr>";
            }
        }
        echo '</table>';
    }
    ?>
            </div>
        <hr>
        
        <div class="profiltorles">
            <form action="./php/profiltorles.php" method="post" id="deleteProfileForm">
            <button type="submit" name="torol" >Profil törlése</button>
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