<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user'])) {
    // Betöltjük a felhasználók adatait tartalmazó JSON fájlt
    $json_file = '../json/users.json';
    $json_data = json_decode(file_get_contents($json_file), true);

    // Ellenőrizzük, hogy a felhasználó létezik-e a JSON fájlban
    $username = $_SESSION['user']['felhasznalonev'];
    $found = false;
    foreach ($json_data['users'] as $key => $user) {
        if ($user['felhasznalonev'] === $username) {
            // Töröljük a felhasználót a JSON fájlból a felhasználónév alapján
            unset($json_data['users'][$key]);
            $found = true;
            break;
        }
    }

    if ($found) {
        // Menti a módosításokat a JSON fájlba
        file_put_contents($json_file, json_encode($json_data));

        // Visszajelzés a sikeres törlésről
        echo "A profil sikeresen törölve.";

        // Kiléptetjük a felhasználót
        unset($_SESSION['user']);
        header("Location: ../index.php");
    } else {
        // Ha a felhasználó nem található a JSON fájlban
        echo "Hiba történt a profil törlése közben: A felhasználó nem található.";
    }
} else {
    // Ha a kérés nem POST, vagy a felhasználó nincs bejelentkezve
    echo "Hiba történt a profil törlése közben: Nem megfelelő kérés.";
}
?>
