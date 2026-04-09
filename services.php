<?php
session_start();
require_once "config/database.php";

$sql = "SELECT * FROM services";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Szolgáltatások</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">
    <span>🦷 Fogászat</span>
    <div>
        <a href="dashboard.php">Főoldal</a>
        <a href="book.php">Foglalás</a>
        <a href="logout.php">Kijelentkezés</a>
    </div>
</nav>

<div class="container">
    <h2>Szolgáltatások</h2>

    <table>
        <tr>
            <th>Szolgáltatás</th>
            <th>Leírás</th>
            <th>Ár</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row["name"]; ?></td>
            <td><?php echo $row["description"]; ?></td>
            <td><?php echo $row["price"]; ?> Ft</td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
