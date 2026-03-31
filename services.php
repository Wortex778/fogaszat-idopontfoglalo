<?php
session_start();
require_once "config/database.php";

$sql = "SELECT * FROM services";
$result = $conn->query($sql);
?>

<h2>Szolgáltatások</h2>

<?php
while($row = $result->fetch_assoc()) {
    echo "<p>";
    echo $row["name"] . " - " . $row["price"] . " Ft<br>";
    echo $row["description"];
    echo "</p><hr>";
}
?>