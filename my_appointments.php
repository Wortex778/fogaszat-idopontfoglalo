<?php
session_start();
require_once "config/database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

$sql = "SELECT appointments.id, services.name, appointments.date, appointments.time
        FROM appointments
        JOIN services ON appointments.service_id = services.id
        WHERE appointments.user_id = '$user_id'";

$result = $conn->query($sql);
?>

<h2>Saját foglalásaim</h2>

<?php
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    echo "<p>";
    echo $row["name"] . " - " . $row["date"] . " " . $row["time"];
    echo " <a href='delete.php?id=".$row["id"]."'>Törlés</a>";
    echo "</p><hr>";
}
} else {
    echo "Nincs foglalásod";
}
?>