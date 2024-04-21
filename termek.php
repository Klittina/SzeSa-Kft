<?php
session_start();
$message = '';

if(isset($_POST["add_to_cart"]))
{
 if(isset($_COOKIE["shopping_cart"]))
 {
  $cookie_data = stripslashes($_COOKIE['shopping_cart']);
  $cart_data = json_decode($cookie_data, true);
 }
 else
 {
  $cart_data = array();
 }

 $item_id_list = array_column($cart_data, 'item_id');

 if(in_array($_POST["hidden_id"], $item_id_list))
 {
  foreach($cart_data as $keys => $values)
  {
   if($cart_data[$keys]["item_id"] == $_POST["hidden_id"])
   {
    $cart_data[$keys]["item_quantity"] = $cart_data[$keys]["item_quantity"] + $_POST["quantity"];
   }
  }
 }
 else
 {
  $item_array = array(
   'item_id'   => $_POST["hidden_id"],
   'item_name'   => $_POST["hidden_name"],
   'item_price'  => $_POST["hidden_price"],
   'item_quantity'  => $_POST["quantity"]
  );
  $cart_data[] = $item_array;
 }

 $item_data = json_encode($cart_data);
 setcookie('shopping_cart', $item_data, time() + (86400 * 30));
 //header("location:index.php?success=1");
}

if(isset($_GET["success"]))
{
 $message = '
 <script>
    alert("A terméket hozzáadtad a kosárhoz!");
</script>
 ';
}

// Fetching product data from JSON file
$product_data = file_get_contents('./json/termekek.json');
$products = json_decode($product_data, true)['termekek'];

// Ellenőrizzük, hogy a cikkszám át lett-e adva az URL-en keresztül
if(isset($_GET['cikkszam'])) {
    // Cikkszám lekérése az URL-ből
    $cikkszam = $_GET['cikkszam'];

    // Fetching product data from JSON file
    $product_data = file_get_contents('./json/termekek.json');
    $products = json_decode($product_data, true)['termekek'];

    // Keressük meg az adott cikkszámú terméket
    $selected_product = null;
    foreach($products as $product) {
        if($product['cikkszam'] == $cikkszam) {
            $selected_product = $product;
            break;
        }
    }

    // Ha megvan az adott termék, megjelenítjük az adatait
    if($selected_product) {
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./kepek/logo.png">
    <link rel="stylesheet" href="./CSS/termek.css">
    <title>Termék részletek</title>
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
            <div class="termek">
                <img src="kepek/<?php echo $selected_product["kep"]; ?>" class="img-responsive" /><br />
                <h4 class="nev">Termék neve: <?php echo $selected_product["megnevezes"]; ?></h4>
                <h4 class="hosszunev">Termék hosszú neve: <?php echo $selected_product["hosszunev"]; ?></h4>
                <h4 class="cikkszam">Cikkszám: <?php echo $selected_product["cikkszam"]; ?></h4>
                <h4 class="gyartoi_cikkszam">Gyártói cikkszám: <?php echo $selected_product["gyartoi_cikkszam"]; ?></h4>
                <h4 class="marka">Márka: <?php echo $selected_product["marka"]; ?></h4>
                <h4 class="gyarto">Gyártó: <?php echo $selected_product["gyarto"]; ?></h4>
                <h4 class="garancia">Garancia: <?php echo $selected_product["garancia"]; ?> nap</h4>
                <h4 class="ar"><?php echo $selected_product["ar"]; ?> Ft</h4>
                <form method="post">
                    <input type="number" name="quantity" value="1" class="szamotbevisz" min="1" />
                    <input type="hidden" name="hidden_name" value="<?php echo $selected_product["megnevezes"]; ?>" />
                    <input type="hidden" name="hidden_price" value="<?php echo $selected_product["ar"]; ?>" />
                    <input type="hidden" name="hidden_id" value="<?php echo $selected_product["cikkszam"]; ?>" />
                    <br>
                    <input type="submit" name="add_to_cart"  class="kosarbarakgomb" value="Kosárba rak" />
                </form>
            </div>
        </article>
        <aside>
    <h2>Hozzászólások</h2>
    <?php
    if(isset($_SESSION["user"])) {
        // Ha be van jelentkezve a felhasználó, megjelenítjük az űrlapot a hozzászólás írásához
    ?>
    <form method="post">
        <input type="hidden" name="cikkszam" value="<?php echo $selected_product["cikkszam"]; ?>" /> <!-- Új sor: cikkszám elmentése -->
        <textarea name="comment" rows="4" cols="50"></textarea><br>
        <input type="submit" name="submit_comment" value="Hozzászólás küldése">
    </form>
    <?php
        // Ha a felhasználó elküldte a hozzászólást
        if(isset($_POST["submit_comment"])) {
            // Ellenőrizzük, hogy a hozzászólás nem üres
            if(!empty($_POST["comment"])) {
                // Hozzáférünk az adott cikkszámhoz kapcsolódó hozzászólásokhoz
                $comments_file = './json/comments.json';
                $comments = [];

                if(file_exists($comments_file)) {
                    $comments = json_decode(file_get_contents($comments_file), true);
                }

                // Új hozzászólás létrehozása
                $new_comment = [
                    "user" => $_SESSION["user"]["felhasznalonev"], // A hozzászóló felhasználóneve
                    "comment" => $_POST["comment"], // A hozzászólás szövege
                    "cikkszam" => $_POST["cikkszam"], // A hozzászólás cikkszáma
                    "timestamp" => date("Y-m-d H:i:s"), // A hozzászólás időbélyege
                    "deletable" => true // Az alapértelmezett érték, hogy a felhasználó törölheti a saját hozzászólását
                ];

                // Hozzáfűzzük az új hozzászólást a többihez
                $comments[] = $new_comment;

                // Frissítjük a kommenteket tartalmazó JSON fájlt
                file_put_contents($comments_file, json_encode($comments, JSON_PRETTY_PRINT));

                // Frissítjük az oldalt, hogy a hozzászólás megjelenjen
                header("Refresh:0");
            } else {
                echo "A hozzászólás nem lehet üres!";
            }
        }
    } else {
        echo "Jelentkezz be, hogy hozzászólást írhass!";
    }

    // Megjelenítjük az összes adott cikkszámhoz tartozó hozzászólást
    $comments_file = './json/comments.json';
    $comments = [];

    if(file_exists($comments_file)) {
        $comments = json_decode(file_get_contents($comments_file), true);
    }
     // Megjelenítjük az összes adott cikkszámhoz tartozó hozzászólást
     if(isset($comments) && is_array($comments)) {
        foreach($comments as $comment) {
            // Ellenőrizzük, hogy a hozzászólás az adott cikkszámhoz tartozik-e
            if($comment['cikkszam'] == $selected_product["cikkszam"]) {
                // Megjelenítjük a hozzászólást és annak adatait
                echo "<div class ='komment'";
                echo "<p class ='felhasznalonev'><strong>Felhasználó:</strong> " . $comment['user'] . "</p>";
                echo "<p class ='tartalom'><strong>Hozzászólás:</strong> " . $comment['comment'] . "</p>";
                echo "<p class ='ido'><strong>Dátum:</strong> " . $comment['timestamp'] . "</p>";
                // Ellenőrizzük, hogy az aktuális felhasználó adminisztrátor-e
                if(isset($_SESSION["user"]) && $_SESSION["user"]["jogosultsag"] == "a") {
                    // Ha az aktuális felhasználó adminisztrátor, megjelenítjük a törlés gombot
                    echo "<form method='post'>";
                    echo "<input type='hidden' name='comment_id' value='" . array_search($comment, $comments) . "' />";
                    echo "<input type='submit' name='delete_comment' value='Törlés' />";
                    echo "</form>";
                }
                echo "</div>";
            }
        }
    } else {
        echo "<p>Még nincsenek hozzászólások.</p>";
    }


    // Ha a törlés gombra kattintottak
    if(isset($_POST["delete_comment"])) {
        // Ellenőrizzük, hogy az aktuális felhasználó adminisztrátor-e
        if(isset($_SESSION["user"]) && $_SESSION["user"]["jogosultsag"] == "a") {
            // Megkeressük a törlendő hozzászólást
            $comment_id = $_POST["comment_id"];
            // Töröljük a hozzászólást a tömbből
            unset($comments[$comment_id]);
            // Frissítjük a JSON fájlt
            file_put_contents($comments_file, json_encode(array_values($comments), JSON_PRETTY_PRINT));
            // Frissítjük az oldalt
            header("Refresh:0");
        }
    }
    ?>
</aside>

        <footer>
            <p>Minden jog fenntartva!</p>
            <p>Szesa Kft</p>
        </footer>
    </main>
</body>
</html>
<?php
    } else {
        // Ha nem találjuk meg az adott cikkszámú terméket, hibaüzenetet jelenítünk meg
        echo "A keresett termék nem található!";
    }
} else {
    // Ha nincs cikkszám átadva az URL-en keresztül, átirányítjuk a felhasználót a főoldalra
    header("Location: index.php");
    exit;
}
?>
