<?php
require_once "config/database.php";

echo "<h2>Adatbázis telepítés...</h2>";

// SQL fájl betöltése
$sql = file_get_contents("database.sql");

if (!$sql) {
    die(" Nem található a database.sql fájl!");
}

// Lekérdezések szétbontása
$queries = explode(";", $sql);

$success = 0;
$error = 0;

foreach ($queries as $query) {
    $query = trim($query);

    if (!empty($query)) {
        if ($conn->query($query)) {
            $success++;
        } else {
            $error++;
            echo "<p style='color:red;'>Hiba: " . $conn->error . "</p>";
        }
    }
}

echo "<p>✔ Sikeres lekérdezések: $success</p>";
echo "<p> Hibák: $error</p>";

echo "<br><a href='index.php'>➡ Indítás</a>";
?>