<?php
 include "funkciok.php";              // beágyazzuk a load_users() és save_users() függvényeket tartalmazó PHP fájlt
 $fiokok = load_users("../json/users.json"); // betöltjük a regisztrált felhasználók adatait, és eltároljuk őket a $fiokok változóban

  // űrlapfeldolgozás
    $hibak = [];

  if (isset($_POST["frissit"])) {   // ha az űrlapot elküldték...
    // a kötelezően kitöltendő mezők ellenőrzése
    echo "<p>müködik</p>";
    if (!isset($_POST["felhasznalonev"]) || trim($_POST["felhasznalonev"]) === "")
      $hibak[] = "A felhasználónév megadása kötelező!";

    if (!isset($_POST["jelszo"]) || trim($_POST["jelszo"]) === "" || !isset($_POST["jelszo2"]) || trim($_POST["jelszo2"]) === "")
      $hibak[] = "A jelszó és az ellenőrző jelszó megadása kötelező!";

    
    // űrlapadatok lementése változókba
    $felhasznalonev = $_POST["felhasznalonev"];
    $jelszo = $_POST["jelszo"];
    $jelszo2 = $_POST["jelszo2"];
    $vezeteknev = $_POST["vezeteknev"];
    $keresztnev = $_POST["keresztnev"];
    $email = $_POST["email"];

    // foglalt felhasználónév ellenőrzése
   /* foreach ($fiokok as $fiok) {
      if ($fiok["felhasznalonev"] === $felhasznalonev)  // ha egy regisztrált felhasználó neve megegyezik az űrlapon megadott névvel...
        $hibak[] = "A felhasználónév már foglalt!";
    }*/

    // túl rövid jelszó
    if (strlen($jelszo) < 5)
      $hibak[] = "A jelszónak legalább 5 karakter hosszúnak kell lennie!";

    // a két jelszó nem egyezik
    if ($jelszo !== $jelszo2)
      $hibak[] = "A jelszó és az ellenőrző jelszó nem egyezik!";

      $siker = FALSE;
    // regisztráció sikerességének ellenőrzése
    if (count($hibak) === 0) {   // ha nem történt hiba a regisztráció során, hozzáadjuk az újonnan regisztrált felhasználót a $fiokok tömbhöz
      $jelszo = password_hash($jelszo, PASSWORD_DEFAULT);       // jelszó hashelése
      // hozzáfűzzük az újonnan regisztrált felhasználó adatait a rendszer által ismert felhasználókat tároló tömbhöz
      $fiok[] = [
        "felhasznalonev" => $felhasznalonev, 
        "jelszo" => $jelszo, 
        "vezeteknev" => $vezeteknev,
        "keresztnev" => $keresztnev, 
        "email" => $email,
        "jogosultsag" => "f"
      ];
      // elmentjük a kibővített $fiokok tömböt a users.json fájlba
      save_users("../json/users.json", $fiok);
      $siker = TRUE;
    }
    
    if (isset($siker) && $siker === TRUE) {  // ha nem volt hiba, akkor a regisztráció sikeres
        echo "<p>Sikeres regisztráció!</p>";
        header("Location: ../index.php"); //SIkeres bejelentkezés esetén továbbítja a felhasználót a főoldalra
      } else {                                // az esetleges hibákat kiírjuk egy-egy bekezdésben
        foreach ($hibak as $hiba) {
          echo "<p>" . $hiba . "</p>";
        }
      }
  }
?>
