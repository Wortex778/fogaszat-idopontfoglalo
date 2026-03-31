<?php

require_once "config/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "INSERT INTO users (name, email, password, role) 
            VALUES ('$name', '$email', '$password', 'user')";

    if ($conn->query($sql) === TRUE) {
        echo "Sikeres regisztráció!";
    } else {
        echo "Hiba történt!";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Regisztráció</title>
</head>
<body>

<h2>Regisztráció</h2>

<form method="POST">
    Név: <input type="text" name="name"><br><br>
    Email: <input type="email" name="email"><br><br>
    Jelszó: <input type="password" name="password"><br><br>

    <button type="submit">Regisztráció</button>
</form>

</body>
</html>