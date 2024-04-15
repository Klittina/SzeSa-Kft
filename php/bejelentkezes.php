
<?php
session_start(); 
echo session_id() . "<br/>";
include "funkciok.php";         
$fiokok = load_users("../json/users.json"); 

  $uzenet = "";      

  if (isset($_POST["bejelentkezik"])) { 
   
    if (!isset($_POST["felhasznalonev"]) || trim($_POST["felhasznalonev"]) === "" || !isset($_POST["jelszo"]) || trim($_POST["jelszo"]) === "") {
      $uzenet = "<strong>Hiba:</strong> Adj meg minden adatot!";
    } else {
      $felhasznalonev = $_POST["felhasznalonev"];
      $jelszo = $_POST["jelszo"];

      $uzenet = "Sikertelen belépés! A belépési adatok nem megfelelők!"; 

      foreach ($fiokok["users"] as $fiok) { 
        if ($fiok["felhasznalonev"] === $felhasznalonev && password_verify($jelszo, $fiok["jelszo"])) {
          $uzenet = "Sikeres belépés!"; 
          header("Location: ../index.php");
          $_SESSION["user"] = $fiok;   
          break; 
         }
      }
      echo "<p>" . $uzenet . "</p>";
    }
  }
?>