<?php
  session_start();
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
        <!-- Megjelenítjük az admin fület, ha a felhasználó admin jogosultsággal rendelkezik -->
        <li><a href="admin.php">Admin</a></li>
    <?php } ?>
                 <?php } else { ?>
                   <li><a href="bejelentkezes.php">Bejelentkezés</a></li>
                   <li><a href="regisztracio.php">Regisztráció</a></li>
                 <?php } ?>
            </ul>
        </nav>
        <div id="kosar">
            <table>
                <tbody class="nagykosar">
                <tr>
                <td>Termék megnevezése</td>
                <td>Cikkszám</td>
                <td>Darabára</td>
                <td>Mennyiség</td>
                <td>Összesen</td>
                </tr>
                <tr>
                <td>Apple MacBook Air M1</td>
                <td>6001356</td>
                <td>585.000 Ft</td>
                <td>
                    <button class="minus">-</button>
                    <span class="quantity">3</span>
                    <button class="plus">+</button>
                </td>
                <td>1.755.000 Ft</td>
                </tr>
                <tr>
                <td>Dell XPS 13</td>
                <td>053489</td>
                <td>320.000 Ft</td>
                <td>
                    <button class="minus">-</button>
                    <span class="quantity">1</span>
                    <button class="plus">+</button>
                </td>
                <td>320.000 Ft</td>
                </tr>
                <tr>
                <td></td>
                <td></td>
                <td colspan="3"><table>
                    <tbody id="kicsi">
                    <tr>
                    <td>Összesen:</td>
                    <td>2.075.000 Ft</td>
                    </tr>
                    <tr>
                    <td>Szállítási költség:</td>
                    <td>50.000 Ft</td>
                    </tr>
                    <tr>
                    <td>Fietendő:</td>
                    <td>2.125.000 Ft</td>
                    </tr>
                    </tbody>
                    </table></td>
                </tr>
                </tbody>
                </table>
        </div>
        <script>
            // Keresünk minden minus gombot
            var minusButtons = document.querySelectorAll('.minus');
        
            // Minden minus gombhoz hozzáadjuk az eseménykezelőt
            minusButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    // Keresünk az adott sorban egy quantity osztályú elemet
                    var quantityElement = this.parentElement.querySelector('.quantity');
                    // Csökkentjük az értéket, de legalább 1 legyen
                    var quantity = parseInt(quantityElement.textContent);
                    if (quantity > 1) {
                        quantity--;
                        quantityElement.textContent = quantity;
                    }
                });
            });
        
            // Keresünk minden plus gombot
            var plusButtons = document.querySelectorAll('.plus');
        
            // Minden plus gombhoz hozzáadjuk az eseménykezelőt
            plusButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    // Keresünk az adott sorban egy quantity osztályú elemet
                    var quantityElement = this.parentElement.querySelector('.quantity');
                    // Növeljük az értéket
                    var quantity = parseInt(quantityElement.textContent);
                    quantity++;
                    quantityElement.textContent = quantity;
                });
            });
        </script>
        <footer>
            <p>Minden jog fenntartva!</p>
            <p>Szesa Kft</p>
        </footer>
    </main>
</body>
</html>