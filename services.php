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
    <a href="dashboard.php" class="logo">🦷 Fogászat</a>
    <div>
        <a href="book.php">Foglalás</a>
        <a href="logout.php">Kijelentkezés</a>
    </div>
</nav>

<div class="container">

    <div class="hero">
        <h1>🦷 Szolgáltatásaink</h1>
        <p>Modern fogászati kezelések magas színvonalon</p>
        <a href="book.php" class="btn">Időpont foglalás</a>
    </div>

    <h2>Szolgáltatások</h2>

    <div class="services">
        <?php while($row = $result->fetch_assoc()): ?>
            <a href="service_detail.php?id=<?php echo $row['id']; ?>" class="service-card">
                <h3><?php echo $row["name"]; ?></h3>
                <p><?php echo $row["description"]; ?></p>
                <div class="price"><?php echo $row["price"]; ?> Ft</div>
            </a>
        <?php endwhile; ?>
    </div>

</div>

</body>
</html>