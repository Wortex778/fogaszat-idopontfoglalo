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

    <style>
        body {
            font-family: Arial;
            background-color: #f4f4f4;
            text-align: center;
        }

        .container {
            background: white;
            padding: 30px;
            margin: 50px auto;
            width: 400px;
            border-radius: 10px;
            box-shadow: 0 0 10px gray;
        }

        h2 {
            color: #333;
        }

        .btn {
            display: block;
            margin: 10px;
            padding: 10px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn:hover {
            background: #2980b9;
        }

        .logout {
            background: red;
        }

        .logout:hover {
            background: darkred;
        }
    </style>

</head>
<body>

<div class="container">

    <h2>Üdv, <?php echo $_SESSION["user_name"]; ?>! 👋</h2>

    <a class="btn" href="services.php">Szolgáltatások</a>
    <a class="btn" href="book.php">Időpont foglalás</a>
    <a class="btn" href="#">Saját foglalásaim (hamarosan)</a>

    <a class="btn logout" href="logout.php">Kijelentkezés</a>

</div>

</body>
</html>