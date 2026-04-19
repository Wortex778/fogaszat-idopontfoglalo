<?php
session_start();
require_once "config/database.php";

// AJAX – időpontok
if (isset($_GET["ajax"])) {

    $date = $_GET["date"] ?? '';

    $booked = [];
    $stmt = $conn->prepare("SELECT time FROM appointments WHERE date=?");
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $res = $stmt->get_result();

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

// LOGIN CHECK
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$success = "";
$error = "";

$selected_date = isset($_POST["date"]) ? $_POST["date"] : date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id = $_SESSION["user_id"];
    $service_id = $_POST["service_id"];
    $date = $_POST["date"];
    $time = $_POST["time"];

    if ($date < date("Y-m-d")) {
        $error = "Nem foglalhatsz múltbeli időpontra!";
    } elseif ($time < "08:00" || $time > "16:00") {
        $error = "Csak 08:00–16:00 között foglalhatsz!";
    } else {

        // 🔥 szolgáltatás időtartam
        $stmt = $conn->prepare("SELECT duration FROM services WHERE id=?");
        $stmt->bind_param("i", $service_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $service = $res->fetch_assoc();

        $duration = $service["duration"] ?? 60;

        // 🔥 foglalások lekérése
        $stmt = $conn->prepare("SELECT time FROM appointments WHERE date=?");
        $stmt->bind_param("s", $date);
        $stmt->execute();
        $res = $stmt->get_result();

        $booked = [];
        while ($row = $res->fetch_assoc()) {
            $booked[] = $row["time"];
        }

        // 🔥 ütközés ellenőrzés
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
            $error = "Ez az időpont ütközik egy másik foglalással!";
        } else {

            // ✅ INSERT
            $stmt = $conn->prepare("INSERT INTO appointments (user_id, service_id, date, time, status) VALUES (?, ?, ?, ?, 'függő')");
            $stmt->bind_param("iiss", $user_id, $service_id, $date, $time);

            if ($stmt->execute()) {
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

        <label>Dátum:</label>
        <input type="date" id="date" name="date"
               value="<?php echo $selected_date; ?>"
               min="<?php echo date('Y-m-d'); ?>" required>

        <label>Időpont:</label>
        <select id="time" name="time" required>

        <?php
        $booked = [];
        $stmt = $conn->prepare("SELECT time FROM appointments WHERE date=?");
        $stmt->bind_param("s", $selected_date);
        $stmt->execute();
        $res = $stmt->get_result();

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

        

        <button type="submit">Foglalás</button>

    </form>
</div>

<script>
document.getElementById("date").addEventListener("change", function() {
    let date = this.value;

    fetch("book.php?ajax=1&date=" + date)
    .then(res => res.text())
    .then(data => {
        document.getElementById("time").innerHTML = data;
    });
});

    const serviceSelect = document.querySelector("select[name='service_id']");
    const durationText = document.getElementById("durationText");

    function updateDuration() {
        const text = serviceSelect.options[serviceSelect.selectedIndex].text;
        const match = text.match(/\((.*?)\)/);

        if (match) {
            durationText.innerText = "⏱ Időtartam: " + match[1];
        }
    }

    serviceSelect.addEventListener("change", updateDuration);


    updateDuration();
</script>

</body>
</html>