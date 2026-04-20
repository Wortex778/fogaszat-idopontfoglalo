<?php
session_start();
require_once "config/database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// ✅ SQL OK
$sql = "SELECT appointments.id, services.name, doctors.name AS doctor,
        appointments.date, appointments.time, appointments.status
        FROM appointments
        JOIN services ON appointments.service_id = services.id
        JOIN doctors ON appointments.doctor_id = doctors.id
        WHERE appointments.user_id = '$user_id'
        ORDER BY appointments.date, appointments.time";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Saját foglalásaim</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">
    <a href="dashboard.php" class="logo">🦷 Fogászat</a>
    <div>
        <a href="book.php">Új foglalás</a>
        <a href="logout.php">Kijelentkezés</a>
    </div>
</nav>

<div class="container">
    <h2>Saját foglalásaim</h2>

    <?php if ($result->num_rows > 0): ?>
    <table>
        <tr>
            <th>Szolgáltatás</th>
            <th>Orvos</th>
            <th>Dátum</th>
            <th>Idő</th>
            <th>Státusz</th>
            <th>Törlés</th>
        </tr>

        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row["name"]; ?></td>
            <td><?php echo $row["doctor"]; ?></td>
            <td><?php echo $row["date"]; ?></td>
            <td><?php echo $row["time"]; ?></td>

            <td>
                <?php
                if ($row["status"] == "elfogadva") {
                    echo "<span style='color:green;'>🟢 elfogadva</span>";
                } elseif ($row["status"] == "elutasítva") {
                    echo "<span style='color:red;'>🔴 elutasítva</span>";
                } else {
                    echo "<span style='color:orange;'>🟡 függő</span>";
                }
                ?>
            </td>

            <td>
                <a href="delete.php?id=<?php echo $row["id"]; ?>"
                   onclick="return confirm('Biztos törlöd ezt a foglalást?')">
                   🗑 Törlés
                </a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <?php else: ?>
        <p>Nincs még foglalásod. <a href="book.php">Foglalj időpontot!</a></p>
    <?php endif; ?>
</div>

</body>
</html>