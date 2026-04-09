<?php
session_start();
require_once "config/database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["user_id"];
    $service_id = $_POST["service_id"];
    $date = $_POST["date"];
    $time = $_POST["time"];

    $sql = "INSERT INTO appointments (user_id, service_id, date, time)
            VALUES ('$user_id', '$service_id', '$date', '$time')";

    if ($conn->query($sql) === TRUE) {
        $success = "Sikeres foglalás!";
    } else {
        $error = "Hiba történt a foglalás során!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Időpont foglalás</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">
    <span>🦷 Fogászat</span>
    <div>
        <a href="dashboard.php">Főoldal</a>
        <a href="my_appointments.php">Foglalásaim</a>
        <a href="logout.php">Kijelentkezés</a>
    </div>
</nav>

<div class="container">
    <h2>Időpont foglalás</h2>

    <?php if ($success): ?><div class="success"><?php echo $success; ?></div><?php endif; ?>
    <?php if ($error): ?><div class="error"><?php echo $error; ?></div><?php endif; ?>

    <form method="POST">
        <label>Dátum:</label>
        <input type="date" name="date" required>

        <label>Idő:</label>
        <input type="time" name="time" required>

        <label>Szolgáltatás:</label>
        <select name="service_id">
            <?php
            $services = $conn->query("SELECT * FROM services");
            while($s = $services->fetch_assoc()) {
                echo "<option value='".$s["id"]."'>".$s["name"]."</option>";
            }
            ?>
        </select>

        <button type="submit">Foglalás</button>
    </form>
</div>

</body>
</html>
