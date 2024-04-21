<?php 
session_start();

if(isset($_POST["ujrendeles"])) {
    if(isset($_SESSION["user"])) {
        $user_name = $_SESSION["user"]["felhasznalonev"];
        $order_id = uniqid(); // Generálunk egyedi azonosítót a rendelésnek
        
        if(isset($_COOKIE["shopping_cart"])) {
            $cookie_data = stripslashes($_COOKIE['shopping_cart']);
            $cart_data = json_decode($cookie_data, true);
            
            // A rendelés adatainak előkészítése
            $order_details = array(
                "rendelesid" => $order_id,
                "felhasznalonev" => $user_name,
                "termekek" => $cart_data
            );
            
            // Hozzáadjuk az új rendelést a rendelések JSON fájlhoz
            $orders_data = file_get_contents('./json/rendelesek.json');
            $orders = json_decode($orders_data, true);
            $orders[] = $order_details;
            file_put_contents('./json/rendelesek.json', json_encode($orders));
            
            // Kosár kiürítése
            setcookie("shopping_cart", "", time() - 3600);
            
            // Visszatérhetünk a főoldalra vagy egyéb kezelést végezhetünk
            header("location:index.php?order_success=1");
            exit();
        }
    }
}
?>
