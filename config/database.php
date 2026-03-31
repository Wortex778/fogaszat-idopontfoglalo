<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "dental_db";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Hiba: nem sikerült csatlakozni az adatbázishoz");
}

?>