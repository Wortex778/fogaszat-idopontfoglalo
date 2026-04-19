<?php
session_start();
require_once "config/database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

$sql = "SELECT appointments.id, services.name, appointments.date, appointments.time
        FROM appointments
        JOIN services ON appointments.service_id = services.id
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
            <th>Dátum</th>
            <th>Idő</th>
            <th>Törlés</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row["name"]; ?></td>
            <td><?php echo $row["date"]; ?></td>
            <td><?php echo $row["time"]; ?></td>
            <td><a href="delete.php?id=<?php echo $row["id"]; ?>">🗑 Törlés</a></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php else: ?>
        <p>Nincs még foglalásod. <a href="book.php">Foglalj időpontot!</a></p>
    <?php endif; ?>
</div>

</body>
</html>
