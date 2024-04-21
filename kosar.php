<?php 
session_start();
$message = '';

// Ha nincs bejelentkezve a felhasználó, és az URL-ben nincs beírva a kosar.php, akkor átirányítjuk a bejelentkezési oldalra
if (!isset($_SESSION["user"]) && basename($_SERVER['PHP_SELF']) != 'bejelentkezes.php') {
    header("Location: bejelentkezes.php");
    exit;
}

if(isset($_GET["action"]))
{
    if($_GET["action"] == "delete")
    {
        $cookie_data = stripslashes($_COOKIE['shopping_cart']);
        $cart_data = json_decode($cookie_data, true);
        foreach($cart_data as $keys => $values)
        {
            if($cart_data[$keys]['item_id'] == $_GET["id"])
            {
                unset($cart_data[$keys]);
                $item_data = json_encode($cart_data);
                setcookie("shopping_cart", $item_data, time() + (86400 * 30));
                // Nincs header függvény, maradunk a jelenlegi oldalon
                // header("location:index.php?remove=1");

                // Most frissítjük a kosár oldalt, hogy az új tartalom jelenjen meg
                echo "<script>window.location.href = window.location.href.split('?')[0] + '?remove=1';</script>";
                exit();
            }
        }
    }
    if($_GET["action"] == "clear")
    {
        setcookie("shopping_cart", "", time() - 3600);
        // Nincs header függvény, maradunk a jelenlegi oldalon
        // header("location:index.php?clearall=1");

        // Most frissítjük a kosár oldalt, hogy az új tartalom jelenjen meg
        echo "<script>window.location.href = window.location.href.split('?')[0] + '?clearall=1';</script>";
        exit();
    }
}

if(isset($_GET["remove"]))
{
 $message = '
 <script>
    alert("Törölted ezt a terméket a kosárból!");
</script>
 ';
}
if(isset($_GET["clearall"]))
{
 $message = '
 <script>
    alert("A kosár tartalma törölve lett!");
</script>
 ';
}

// Fetching product data from JSON file
$product_data = file_get_contents('./json/termekek.json');
$products = json_decode($product_data, true)['termekek'];

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
   <div style="clear:both"></div>
   <br />
   <h3>Kosár</h3>
   <br>
   <div class="table-responsive">
   <?php echo $message; ?>
    <a href="kosar.php?action=clear"><p class="gomb elsogomb">Kosár törlése</p></a>
    <br><br>
   </div>
   <table class="table table-bordered">
    <tr>
     <th width="40%">Termék neve</th>
     <th width="10%">Mennyiség</th>
     <th width="20%">Ár</th>
     <th width="15%">Összesen</th>
     <th width="5%"></th>
    </tr>
   <?php
   if(isset($_COOKIE["shopping_cart"]))
   {
    $total = 0;
    $cookie_data = stripslashes($_COOKIE['shopping_cart']);
    $cart_data = json_decode($cookie_data, true);
    foreach($cart_data as $keys => $values)
    {
   ?>
    <tr>
     <td><?php echo $values["item_name"]; ?></td>
     <td>
     <button class="minus">-</button>
        <?php echo $values["item_quantity"]; ?>
        <button class="plus">+</button>
    </td>
     <td> <?php echo $values["item_price"]; ?> Ft</td>
     <td> <?php echo number_format($values["item_quantity"] * $values["item_price"]);?> Ft</td>
     <td><a href="kosar.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Termék törlése</span></a></td>
    </tr>
   <?php 
     $total = $total + ($values["item_quantity"] * $values["item_price"]);
    }
   ?>
    <tr>
     <td colspan="3" align="right">Teljes összeg</td>
     <td align="right"> <?php echo number_format($total); ?> Ft</td>
     <td></td>
    </tr>
   <?php
   }
   else
   {
    echo '
    <tr>
     <td colspan="5" align="center">Nincs termék a kosárban</td>
    </tr>
    ';
   }
   ?>
   </table>
   <br>
    <input type="submit" value="Rendelés megerősítése" name="ujrendeles" class="gomb">
   </div>
  </div>
</div>

    <footer class="footer">
        <p>Minden jog fenntartva!</p>
        <p>Szesa Kft</p>
    </footer>
</main>
</body>
</html>
