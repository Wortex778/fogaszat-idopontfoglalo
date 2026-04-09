<?php
require_once "config/database.php";

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "INSERT INTO users (name, email, password, role) 
            VALUES ('$name', '$email', '$password', 'user')";

    if ($conn->query($sql) === TRUE) {
        $success = "Sikeres regisztráció! <a href='login.php'>Bejelentkezés</a>";
    } else {
        $error = "Hiba történt a regisztráció során!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Regisztráció</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Regisztráció</h2>

    <?php if ($success): ?><div class="success"><?php echo $success; ?></div><?php endif; ?>
    <?php if ($error): ?><div class="error"><?php echo $error; ?></div><?php endif; ?>

    <form method="POST">
        <label>Név:</label>
        <input type="text" name="name" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Jelszó:</label>
        <input type="password" name="password" required>

        <button type="submit">Regisztráció</button>
    </form>

    <p>Már van fiókod? <a href="login.php">Bejelentkezés</a></p>
</div>

</body>
</html>
