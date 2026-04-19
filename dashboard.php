<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">
    <span>🦷 Fogászat</span>
    <div>
        <a href="logout.php">Kijelentkezés</a>
    </div>
</nav>

<div class="container">
    <h2>Üdv, <?php echo $_SESSION["user_name"]; ?>! 👋</h2>

    <div class="menu">
        <a class="btn" href="services.php">Szolgáltatások</a>
        <a class="btn" href="book.php">Időpont foglalás</a>
        <a class="btn" href="my_appointments.php">Saját foglalásaim</a>
    </div>
</div>

</body>
</html>
