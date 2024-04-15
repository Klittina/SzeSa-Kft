<?php
  function save_users(string $path, array $new_users) {
    $users = load_users($path);

    // Először betöltjük a már meglévő felhasználókat
    $existing_users = load_users($path);

    // Ha nincsenek meglévő felhasználók, akkor az új felhasználók listája lesz az összes felhasználó
    if (empty($existing_users["users"])) {
        $existing_users["users"] = $new_users;
    } else {
        // Ha vannak meglévő felhasználók, akkor hozzáadjuk az új felhasználókat a meglévőkhöz
        $existing_users["users"] = array_merge($existing_users["users"], $new_users);
    }

    // JSON formátumba alakítjuk az összes felhasználót és mentjük a fájlba
    $json_data = json_encode($existing_users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    file_put_contents($path, $json_data);
  }

  function load_users(string $path): array {
    if (!file_exists($path))
      die("Nem sikerült a fájl megnyitása!");

    $json = file_get_contents($path);

    return json_decode($json, true);
  }
?>
