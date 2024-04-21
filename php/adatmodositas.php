<?php
session_start();
include "funkciok.php";

$fiokok = load_users("../json/users.json");

$hibak = [];
$uzenet = "";

if (isset($_POST["frissit"])) {
    if(isset($_POST["felhasznalonev"])) {
        $felhasznalonev = $_POST["felhasznalonev"];
        $jelszo = $_POST["jelszo"];
        $jelszo2 = $_POST["jelszo2"];
        $vezeteknev = $_POST["vezeteknev"];
        $keresztnev = $_POST["keresztnev"];
        $email = $_POST["email"];
        if (empty($felhasznalonev) || empty($jelszo) || empty($jelszo2) || empty($vezeteknev) || empty($keresztnev) || empty($email)) {
            $hibak[] = "<strong>Hiba:</strong> Adj meg minden adatot!";
        } else {
            if ($jelszo !== $jelszo2) {
                $hibak[] = "A jelszó és az ellenőrző jelszó nem egyezik!";
            } elseif (strlen($jelszo) < 5) {
                $hibak[] = "A jelszónak legalább 5 karakter hosszúnak kell lennie!";
            } else {
                foreach ($fiokok["users"] as $key => $fiok) {
                    if ($fiok["felhasznalonev"] === $felhasznalonev && count($hibak) === 0) {
                        $jelszo_hash = password_hash($jelszo, PASSWORD_DEFAULT);
                        $fiokok["users"][$key]["jelszo"] = $jelszo_hash;
                        $fiokok["users"][$key]["vezeteknev"] = $vezeteknev;
                        $fiokok["users"][$key]["keresztnev"] = $keresztnev;
                        $fiokok["users"][$key]["email"] = $email;
                        save_users("../json/users.json", $fiokok);
                        $uzenet = "Sikeres frissítés!";
                        $_SESSION["user"] = $fiokok["users"][$key];
                        break;
                    }
                }
            }
        }
    } else {
        $uzenet = "<strong>Hiba:</strong> A felhasználónév nem érkezett meg a POST kérésben!";
    }
}
?>
