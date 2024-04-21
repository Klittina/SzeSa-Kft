<?php
session_start();

// Ellenőrizzük, hogy van-e bejelentkezett felhasználó
if (!isset($_SESSION["user"])) {
    header("Location: bejelentkezes.php");
    exit;
}

// Frissítjük a bejelentkezett felhasználó profilképének elérési útját
foreach ($_SESSION["users"] as &$user) {
    if ($user["felhasznalonev"] === $_SESSION["user"]["felhasznalonev"]) {
        $user["kep"] = "kepek/" . basename($_FILES["fileToUpload"]["name"]);
        $_SESSION["user"]["kep"] = $user["kep"]; // Frissítjük a bejelentkezett felhasználó profilképét is
        break;
    }
}

// Mentsük el a frissített felhasználói adatokat a JSON fájlba
$jsondata = json_encode(array("users" => $_SESSION["users"]), JSON_PRETTY_PRINT);
file_put_contents('users.json', $jsondata);

// További feltöltési logika...
?>
