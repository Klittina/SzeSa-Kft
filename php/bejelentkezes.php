
<?php
session_start(); 
  include "funkciok.php";              // a load_users() függvény ebben a fájlban van
  $fiokok = load_users("felhasznalok.json"); // betöltjük a regisztrált felhasználók adatait, és eltároljuk őket a $fiokok változóban

  $uzenet = "";                     // az űrlap feldolgozása után kiírandó üzenet

  if (isset($_POST["login"])) {    // miután az űrlapot elküldték...
    if (!isset($_POST["felhasznalonev"]) || trim($_POST["felhasznalonev"]) === "" || !isset($_POST["jelszo"]) || trim($_POST["jelszo"]) === "") {
      // ha a kötelezően kitöltendő űrlapmezők valamelyike üres, akkor hibaüzenetet jelenítünk meg
      $uzenet = "<strong>Hiba:</strong> Adj meg minden adatot!";
    } else {
      // ha megfelelően kitöltötték az űrlapot, lementjük az űrlapadatokat egy-egy változóba
      $felhasznalonev = $_POST["felhasznalonev"];
      $jelszo = $_POST["jelszo"];

      // bejelentkezés sikerességének ellenőrzése
      $uzenet = "Sikertelen belépés! A belépési adatok nem megfelelők!";  // alapból azt feltételezzük, hogy a bejelentkezés sikertelen

      foreach ($fiokok["felhasznalok"] as $fiok) {              // végigmegyünk a regisztrált felhasználókon
        // a bejelentkezés pontosan akkor sikeres, ha az űrlapon megadott felhasználónév-jelszó páros megegyezik egy regisztrált felhasználó belépési adataival
        // a jelszavakat hash alapján, a password_verify() függvénnyel hasonlítjuk össze
        if ($fiok["felhasznalonev"] === $felhasznalonev && password_verify($jelszo, $fiok["jelszo"])) {
          $uzenet = "Sikeres belépés!";        // ekkor átírjuk a megjelenítendő üzenet szövegét
          $_SESSION["user"] = $fiok;   
          break;                               // mivel találtunk illeszkedést, ezért a többi felhasználót nem kell megvizsgálnunk, kilépünk a ciklusból 
        }
      }
    }
  }
?>