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
               appointments.date, appointments.time, appointments.status
        FROM appointments
        JOIN users ON appointments.user_id = users.id
        JOIN services ON appointments.service_id = services.id";

$result = $conn->query($sql);

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

        <p>Összes foglalás: <strong><?php echo $total["total"]; ?></strong></p>

        <ul>
        <?php while($row = $stats->fetch_assoc()): ?>
            <li>
                <span><?php echo $row["name"]; ?></span>
                <span><?php echo $row["db"]; ?> db</span>
            </li>
        <?php endwhile; ?>
        </ul>
    </div>

    <table>
        <tr>
            <th>Felhasználó</th>
            <th>Szolgáltatás</th>
            <th>Dátum</th>
            <th>Idő</th>
            <th>Státusz</th>
            <th>Művelet</th>
        </tr>

        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row["name"]}</td>
                    <td>{$row["service"]}</td>
                    <td>{$row["date"]}</td>
                    <td>{$row["time"]}</td>
                    <td>{$row["status"]}</td>
                    <td>
                        <a href='admin.php?approve={$row["id"]}'>✔</a>
                        <a href='admin.php?reject={$row["id"]}'>❌</a>
                        <a href='admin.php?delete={$row["id"]}'
                           onclick=\"return confirm('Biztos törlöd?')\">
                           🗑
                        </a>
                    </td>
                  </tr>";
        }
        ?>
    </table>
</div>

</body>
</html>