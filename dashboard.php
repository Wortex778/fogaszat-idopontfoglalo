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

    <a href="services.php">Szolgáltatások</a>
    <a href="book.php">Időpont foglalás</a>
    <a href="my_appointments.php">Saját foglalásaim</a>
    <a href="logout.php">Kijelentkezés</a>
</div>

</body>
</html>
