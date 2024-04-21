<?php
session_start();

// Ellenőrizzük, hogy be van-e jelentkezve a felhasználó
if(!isset($_SESSION["user"])) {
    header("Location: bejelentkezes.php");
    exit;
}

// Ellenőrizzük, hogy van-e termék a kosárban
if(isset($_COOKIE["shopping_cart"])) {
    $cookie_data = stripslashes($_COOKIE['shopping_cart']);
    $cart_data = json_decode($cookie_data, true);
    
    // Mentjük a kosár tartalmát egy JSON fájlba
    $order_file = '../json/orders.json';
    $orders = [];

    if(file_exists($order_file)) {
        $orders = json_decode(file_get_contents($order_file), true);
    }

    // Kiszámítjuk a következő rendelés azonosítóját
    $next_order_id = count($orders) + 1;

    // Felhasználónév azonosítóként
    $user_id = $_SESSION["user"]["felhasznalonev"];

    $new_order = [
        "id" => $next_order_id,
        "user_id" => $user_id,
        "items" => $cart_data,
        "total" => 0 // Itt még nincs kiszámítva a teljes összeg
    ];

    // Kiszámítjuk a teljes összeget
    foreach($cart_data as $item) {
        $new_order["total"] += $item["item_quantity"] * $item["item_price"];
    }

    // Hozzáadjuk az új rendelést a megrendelések listájához
    $orders["orders"][] = $new_order;

    // Mentjük az új rendeléseket a JSON fájlba
    file_put_contents($order_file, json_encode($orders, JSON_PRETTY_PRINT));

    // Töröljük a kosár tartalmát
    unset($_COOKIE['shopping_cart']);
    setcookie('shopping_cart', '', time() - 3600);
    
    // Átirányítás a főoldalra vagy más megfelelő helyre
    header("Location: ../kosar.php?action=rendeles");
    exit;
} else {
    // Ha nincs termék a kosárban, visszairányítjuk a felhasználót a kosár oldalra
    header("Location: ../kosar.php");
    exit;
}
?>
