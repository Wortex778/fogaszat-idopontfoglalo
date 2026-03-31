<?php
session_start();
require_once "config/database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id = $_SESSION["user_id"];
    $service_id = $_POST["service_id"];
    $date = $_POST["date"];
    $time = $_POST["time"];

    $sql = "INSERT INTO appointments (user_id, service_id, date, time)
            VALUES ('$user_id', '$service_id', '$date', '$time')";

    if ($conn->query($sql) === TRUE) {
        echo "Sikeres foglalás!";
    } else {
        echo "Hiba!";
    }
}
?>

<h2>Időpont foglalás</h2>

<form method="POST">

    Dátum: <input type="date" name="date"><br><br>
    Idő: <input type="time" name="time"><br><br>

    Szolgáltatás:
    <select name="service_id">
        <?php
        $services = $conn->query("SELECT * FROM services");
        while($s = $services->fetch_assoc()) {
            echo "<option value='".$s["id"]."'>".$s["name"]."</option>";
        }
        ?>
    </select>

    <br><br>

    <button type="submit">Foglalás</button>
</form>