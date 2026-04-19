<?php
session_start();
require_once "config/database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$success = "";
$error = "";

// kiválasztott dátum (alapból ma)
$selected_date = isset($_POST["date"]) ? $_POST["date"] : date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id = $_SESSION["user_id"];
    $service_id = $_POST["service_id"];
    $date = $_POST["date"];
    $time = $_POST["time"];

    if ($date < date("Y-m-d")) {
        $error = "Nem foglalhatsz múltbeli időpontra!";
    } else {

        $check = "SELECT * FROM appointments 
                  WHERE date='$date' AND time='$time'";
        $result = $conn->query($check);

        if ($result->num_rows > 0) {
            $error = "Ez az időpont már foglalt!";
        } else {

            $sql = "INSERT INTO appointments (user_id, service_id, date, time)
                    VALUES ('$user_id', '$service_id', '$date', '$time')";

            if ($conn->query($sql) === TRUE) {
                $success = "Sikeres foglalás!";
            } else {
                $error = "Hiba történt!";
            }
        }
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
    <a href="dashboard.php" class="logo">🦷 Fogászat</a>   
    <div>
        <a href="my_appointments.php">Foglalásaim</a>
        <a href="logout.php">Kijelentkezés</a>
    </div>
</nav>

<div class="container">
    <h2>Időpont foglalás</h2>

    <?php if ($success): ?>
        <div class="success"><?php echo $success; ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">

        <label for="date">Dátum:</label>
        <input type="date" id="date" name="date"
               value="<?php echo $selected_date; ?>"
               min="<?php echo date('Y-m-d'); ?>" required>

        <label for="time">Időpont:</label>
        <select id="time" name="time" required>

            <?php
            // foglalt idők lekérése
            $booked = [];
            $res = $conn->query("SELECT time FROM appointments WHERE date='$selected_date'");
            while ($row = $res->fetch_assoc()) {
                $booked[] = $row["time"];
            }

            // időpontok generálása 08:00–16:00
            for ($i = 8; $i <= 16; $i++) {
                $hour = str_pad($i, 2, "0", STR_PAD_LEFT) . ":00";

                if (!in_array($hour, $booked)) {
                    echo "<option value='$hour'>$hour</option>";
                }
            }
            ?>

        </select>

        <label for="service_id">Szolgáltatás:</label>
        <select id="service_id" name="service_id" required>
            <?php
            $services = $conn->query("SELECT * FROM services");
            while ($s = $services->fetch_assoc()) {
                echo "<option value='{$s["id"]}'>{$s["name"]}</option>";
            }
            ?>
        </select>

        <button type="submit">Foglalás</button>

    </form>
</div>

</body>
</html>