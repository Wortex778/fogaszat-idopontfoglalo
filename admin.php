<?php
session_start();
require_once "config/database.php";

// csak admin léphet be
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: login.php");
    exit();
}

// törlés
if (isset($_GET["delete"])) {
    $id = $_GET["delete"];
    $conn->query("DELETE FROM appointments WHERE id='$id'");
    header("Location: admin.php");
    exit();
}

// foglalások lekérése
$sql = "SELECT appointments.id, users.name, services.name AS service, appointments.date, appointments.time
        FROM appointments
        JOIN users ON appointments.user_id = users.id
        JOIN services ON appointments.service_id = services.id";

$result = $conn->query($sql);
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

    <table>
        <tr>
            <th>Felhasználó</th>
            <th>Szolgáltatás</th>
            <th>Dátum</th>
            <th>Idő</th>
            <th>Művelet</th>
        </tr>

        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row["name"]}</td>
                    <td>{$row["service"]}</td>
                    <td>{$row["date"]}</td>
                    <td>{$row["time"]}</td>
                    <td>
                        <a href='admin.php?delete={$row["id"]}'
                           onclick=\"return confirm('Biztos törlöd?')\">
                           ❌ Törlés
                        </a>
                    </td>
                  </tr>";
        }
        ?>
    </table>
</div>

</body>
</html>