<?php
include "funkciok.php";
$termekek = load_products("termekek.json");

$hibak = [];

if (isset($_POST["ujtermek"])) {
    if (!isset($_POST["megnevezes"]) || trim($_POST["megnevezes"]) === "") {
        $hibak[] = "A termék nevét megadni kötelező!";
    }
    $megnevezes = $_POST["megnevezes"];
    $ar = $_POST["ar"];
    $kep;

    if (isset($_FILES["kep"])) {
        $engedelyezett_kiterjesztesek = ["jpg", "jpeg", "png"];
        $kiterjesztes = strtolower(pathinfo($_FILES["kep"]["name"], PATHINFO_EXTENSION));

        if (in_array($kiterjesztes, $engedelyezett_kiterjesztesek)) {
            if ($_FILES["kep"]["error"] === 0) {
                if ($_FILES["kep"]["size"] <= 31457280) {
                    $cel = "../kepek/" . $_FILES["kep"]["name"];

                    if (move_uploaded_file($_FILES["kep"]["tmp_name"], $cel)) {
                        echo "Sikeres fájlfeltöltés! <br/>";
                        $kep = $_FILES["kep"]["name"];
                    } else {
                        $hibak[] = "<strong>Hiba:</strong> A fájl átmozgatása nem sikerült! <br/>";
                    }
                } else {
                    $hibak[] = "<strong>Hiba:</strong> A fájl mérete túl nagy! <br/>";
                }
            } else {
                $hibak[] = "<strong>Hiba:</strong> A fájlfeltöltés nem sikerült! <br/>";
            }
        } else {
            $hibak[] = "<strong>Hiba:</strong> A fájl kiterjesztése nem megfelelő! <br/>";
        }
    }

    if (count($hibak) === 0) { 
        $termeklista = load_products("termekek.json");

        $ujtermek = [
            "megnevezes" => $megnevezes, 
            "ar" => $ar,
            "kep" => $kep
        ];
        save_products("termekek.json", $ujtermek);

        $siker = true;
    }

    if (isset($siker) && $siker === true) {
        echo "<p>Sikeres termékfelvitel!</p>";
    } else {
        foreach ($hibak as $hiba) {
            echo "<p>" . $hiba . "</p>";
        }
    }
}
?>
