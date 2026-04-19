<?php
session_start();

if (isset($_SESSION["user_id"])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Fogászati időpontfoglaló</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>🦷 Fogászati időpontfoglaló</h1>
    <p>Foglalj időpontot gyorsan és egyszerűen!</p>

    <a href="login.php" class="btn">Bejelentkezés</a>
    <a href="register.php" class="btn">Regisztráció</a>
</div>

</body>
</html>
