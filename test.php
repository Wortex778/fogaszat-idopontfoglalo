<?php

require_once "config/database.php";

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "Név: " . $row["name"] . "<br>";
    }
} else {
    echo "Nincs adat a users táblában";
}

?>