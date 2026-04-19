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
    <a href="dashboard.php" class="logo">🦷 Fogászat</a>
    <div>
        <a href="logout.php">Kijelentkezés</a>
    </div>
</nav>

<div class="container">
    <h2>Üdv, <?php echo $_SESSION["user_name"]; ?>! 👋</h2>

    <div class="cards">

    <a href="services.php" class="card">
        <h3>🦷 Szolgáltatások</h3>
        <p>Elérhető kezelések</p>
    </a>

    <a href="book.php" class="card">
        <h3>📅 Időpont foglalás</h3>
        <p>Új időpont foglalása</p>
    </a>

    <a href="my_appointments.php" class="card">
        <h3>📋 Foglalásaim</h3>
        <p>Időpontok megtekintése</p>
    </a>

    <?php if (isset($_SESSION["role"]) && $_SESSION["role"] == "admin"): ?>
        <a href="admin.php" class="card">
            <h3>⚙️ Admin panel</h3>
            <p>Foglalások kezelése</p>
        </a>
    <?php endif; ?>

    </div>
</div>

</body>
</html>