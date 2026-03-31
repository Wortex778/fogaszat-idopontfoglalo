<?php
session_start();
require_once "config/database.php";

if (isset($_GET["id"])) {

    $id = $_GET["id"];

    $sql = "DELETE FROM appointments WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: my_appointments.php");
        exit();
    } else {
        echo "Hiba törléskor";
    }
}
?>