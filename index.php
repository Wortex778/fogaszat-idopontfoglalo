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
    <title>Főoldal</title>

    <style>
        body {
            font-family: Arial;
            text-align: center;
            background-color: #f4f4f4;
        }

        .container {
            margin-top: 100px;
        }

        a {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        a:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Fogászati időpontfoglaló</h1>

    <a href="login.php">Bejelentkezés</a>
    <a href="register.php">Regisztráció</a>
</div>

</body>
</html>