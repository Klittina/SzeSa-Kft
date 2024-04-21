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
   foreach($products as $row)
   {
   ?>
   <div class="termek">
    <form method="post">
    <img src="kepek/<?php echo $row["kep"]; ?>" class="img-responsive" /><br />

      <h4 class="nev"><?php echo $row["megnevezes"]; ?></h4>

      <h4 class="ar">$ <?php echo $row["ar"]; ?></h4>

      <input type="text" name="quantity" value="1" class="form-control" />
      <input type="hidden" name="hidden_name" value="<?php echo $row["megnevezes"]; ?>" />
      <input type="hidden" name="hidden_price" value="<?php echo $row["ar"]; ?>" />
      <input type="hidden" name="hidden_id" value="<?php echo $row["cikkszam"]; ?>" />
      <br>
      <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Kosárba rak" />
    </form>
   </div>
   <?php
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
