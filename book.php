<?php
session_start();
require_once "config/database.php";

if (isset($_GET["ajax"])) {

    $date = $_GET["date"] ?? '';

    $stmt = $conn->prepare("SELECT time FROM appointments WHERE date=?");
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $res = $stmt->get_result();

    $booked = [];
    while ($row = $res->fetch_assoc()) {
        $booked[] = $row["time"];
    }

    for ($i = 8; $i <= 16; $i++) {
        $hour = str_pad($i, 2, "0", STR_PAD_LEFT) . ":00";

        if (!in_array($hour, $booked)) {
            echo "<option value='$hour'>$hour</option>";
        }
    }

    exit();
}


if (!isset($_SESSION["user_id"])) {
    header("Location: /fogaszat/login.php");
    exit();
}

$success = "";
$error = "";
$selected_date = $_POST["date"] ?? date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id = $_SESSION["user_id"];
    $service_id = $_POST["service_id"];
    $doctor_id = $_POST["doctor_id"];
    $date = $_POST["date"];
    $time = $_POST["time"];

    if ($date < date("Y-m-d")) {
        $error = "Nem foglalhatsz múltbeli időpontra!";
    } elseif ($time < "08:00" || $time > "16:00") {
        $error = "Csak 08:00–16:00 között foglalhatsz!";
    } else {

        $stmt = $conn->prepare("SELECT name, duration FROM services WHERE id=?");
        $stmt->bind_param("i", $service_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $service = $res->fetch_assoc();

        $duration = $service["duration"] ?? 60;

        $stmt = $conn->prepare("SELECT time FROM appointments WHERE date=?");
        $stmt->bind_param("s", $date);
        $stmt->execute();
        $res = $stmt->get_result();

        $booked = [];
        while ($row = $res->fetch_assoc()) {
            $booked[] = $row["time"];
        }

        $start = strtotime($time);
        $end = $start + ($duration * 60);

        $conflict = false;

        foreach ($booked as $b) {
            $b_start = strtotime($b);
            $b_end = $b_start + 3600;

            if ($start < $b_end && $end > $b_start) {
                $conflict = true;
                break;
            }
        }

        if ($conflict) {
            $error = "Ez az időpont ütközik!";
        } else {

            $stmt = $conn->prepare("
                INSERT INTO appointments 
                (user_id, service_id, doctor_id, date, time, status) 
                VALUES (?, ?, ?, ?, ?, 'függő')
            ");
            $stmt->bind_param("iiiss", $user_id, $service_id, $doctor_id, $date, $time);

            if ($stmt->execute()) {
                $success = "Sikeres foglalás: " . $service["name"];
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
    <a href="/fogaszat/dashboard.php" class="logo">🦷 Fogászat</a>   
    <div>
        <a href="/fogaszat/my_appointments.php">Foglalásaim</a>
        <a href="/fogaszat/logout.php">Kijelentkezés</a>
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

        <label>Dátum:</label>
        <input type="date" id="date" name="date"
               value="<?php echo $selected_date; ?>"
               min="<?php echo date('Y-m-d'); ?>" required>

        <label>Időpont:</label>
        <select id="time" name="time" required>
        <?php
        $stmt = $conn->prepare("SELECT time FROM appointments WHERE date=?");
        $stmt->bind_param("s", $selected_date);
        $stmt->execute();
        $res = $stmt->get_result();

        $booked = [];
        while ($row = $res->fetch_assoc()) {
            $booked[] = $row["time"];
        }

        for ($i = 8; $i <= 16; $i++) {
            $hour = str_pad($i, 2, "0", STR_PAD_LEFT) . ":00";

            if (!in_array($hour, $booked)) {
                echo "<option value='$hour'>$hour</option>";
            }
        }
        ?>
        </select>

        <label>Szolgáltatás:</label>
        <select name="service_id" required>
        <?php
        $selected = $_GET["service_id"] ?? null;

        $services = $conn->query("SELECT * FROM services");
        while ($s = $services->fetch_assoc()) {
            $isSelected = ($selected == $s["id"]) ? "selected" : "";
            echo "<option value='{$s["id"]}' $isSelected>{$s["name"]} ({$s["duration"]} perc)</option>";
        }
        ?>
        </select>

        <label>Orvos:</label>
        <select name="doctor_id" required>
        <?php
        $service_id = $_GET["service_id"] ?? 1;

        $stmt = $conn->prepare("SELECT * FROM doctors WHERE service_id=?");
        $stmt->bind_param("i", $service_id);
        $stmt->execute();
        $docs = $stmt->get_result();
        while ($d = $docs->fetch_assoc()) {
            echo "<option value='{$d["id"]}'>{$d["name"]} ({$d["specialization"]})</option>";
        }
        ?>
        </select>

        <button type="submit">Foglalás</button>

    </form>
</div>

<script>
document.getElementById("date").addEventListener("change", function() {

    let date = this.value;

    fetch("/fogaszat/book.php?ajax=1&date=" + date)
    .then(res => res.text())
    .then(data => {
        document.getElementById("time").innerHTML = data;
    });

});

document.querySelector("select[name='service_id']").addEventListener("change", function() {

    let service = this.value;

    fetch("/fogaszat/get_doctors.php?service_id=" + service)
    .then(res => res.text())
    .then(data => {
        document.querySelector("select[name='doctor_id']").innerHTML = data;
    });

});

window.addEventListener("load", function() {
    let service = document.querySelector("select[name='service_id']").value;

    fetch("/fogaszat/get_doctors.php?service_id=" + service)
    .then(res => res.text())
    .then(data => {
        document.querySelector("select[name='doctor_id']").innerHTML = data;
    });
});

</script>

</body>
</html>