<?php
session_start();
require_once "config/database.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: login.php");
    exit();
}

if (isset($_GET["approve"])) {
    $id = $_GET["approve"];
    $conn->query("UPDATE appointments SET status='elfogadva' WHERE id=$id");
    header("Location: admin.php");
    exit();
}

if (isset($_GET["reject"])) {
    $id = $_GET["reject"];
    $conn->query("UPDATE appointments SET status='elutasítva' WHERE id=$id");
    header("Location: admin.php");
    exit();
}

if (isset($_GET["delete"])) {
    $id = $_GET["delete"];

    $stmt = $conn->prepare("DELETE FROM appointments WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: admin.php");
    exit();
}

$sql = "SELECT appointments.id, users.name, services.name AS service, 
               doctors.name AS doctor,
               appointments.date, appointments.time, appointments.status
        FROM appointments
        JOIN users ON appointments.user_id = users.id
        JOIN services ON appointments.service_id = services.id
        JOIN doctors ON appointments.doctor_id = doctors.id";

$result = $conn->query($sql);

// stat
$total = $conn->query("SELECT COUNT(*) as total FROM appointments")->fetch_assoc();

$stats = $conn->query("
    SELECT services.name, COUNT(*) as db
    FROM appointments
    JOIN services ON appointments.service_id = services.id
    GROUP BY service_id
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin panel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">
    <a href="dashboard.php" class="logo">🦷 Fogászat</a>
    <div>
        <a href="dashboard.php">⬅ Vissza</a>
        <a href="logout.php">Kijelentkezés</a>
    </div>
</nav>

<div class="container">
    <h2>Foglalások</h2>

    <div class="stats">
        <h3>📊 Statisztika</h3>

        <div class="stats-grid">

            <div class="stat-card main">
                <h4>Összes foglalás</h4>
                <p><?php echo $total["total"]; ?></p>
            </div>

            <?php while($row = $stats->fetch_assoc()): ?>
                <div class="stat-card">
                    <h4><?php echo $row["name"]; ?></h4>
                    <p><?php echo $row["db"]; ?> db</p>
                </div>
            <?php endwhile; ?>

        </div>
    </div>

    <table>
        <tr>
            <th>Felhasználó</th>
            <th>Szolgáltatás</th>
            <th>Orvos</th>
            <th>Dátum</th>
            <th>Idő</th>
            <th>Státusz</th>
            <th>Művelet</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row["name"]; ?></td>
            <td><?php echo $row["service"]; ?></td>
            <td><?php echo $row["doctor"]; ?></td>
            <td><?php echo $row["date"]; ?></td>
            <td><?php echo $row["time"]; ?></td>

            <td>
                <?php
                if ($row["status"] == "elfogadva") {
                    echo "<span style='color:green;'> elfogadva</span>";
                } elseif ($row["status"] == "elutasítva") {
                    echo "<span style='color:red;'> elutasítva</span>";
                } else {
                    echo "<span style='color:orange;'> függő</span>";
                }
                ?>
            </td>

            <td>
                <a href="admin.php?approve=<?php echo $row["id"]; ?>">✔</a>
                <a href="admin.php?reject=<?php echo $row["id"]; ?>">❌</a>
                <a href="admin.php?delete=<?php echo $row["id"]; ?>"
                   onclick="return confirm('Biztos törlöd?')">🗑</a>
            </td>
        </tr>
        <?php endwhile; ?>

    </table>
</div>

</body>
</html>