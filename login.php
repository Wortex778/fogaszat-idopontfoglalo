<?php
session_start();

require_once "config/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {

        $user = $result->fetch_assoc();

        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_name"] = $user["name"];

        header("Location: dashboard.php");
        exit();

    } else {
        echo "Hibás adatok!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bejelentkezés</title>
</head>
<body>

<h2>Bejelentkezés</h2>

<form method="POST">
    Email: <input type="email" name="email"><br><br>
    Jelszó: <input type="password" name="password"><br><br>

    <button type="submit">Belépés</button>
</form>

</body>
</html>