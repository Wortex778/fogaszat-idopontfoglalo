<?php
session_start();
require_once "config/database.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];

    // Csak email alapján keresünk
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {

        $user = $result->fetch_assoc();

        // Jelszó ellenőrzés
        if (password_verify($password, $user["password"])) {

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];
            $_SESSION["role"] = $user["role"]; // ✅ IDE KELL

            header("Location: dashboard.php");
            exit();

        } else {
            $error = "Hibás jelszó!";
        }

    } else {
        $error = "Nincs ilyen felhasználó!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bejelentkezés</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Bejelentkezés</h2>

    <?php if ($error): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Jelszó:</label>
        <input type="password" name="password" required>

        <button type="submit">Belépés</button>
    </form>

    <p>Még nincs fiókod? <a href="register.php">Regisztráció</a></p>
</div>

</body>
</html>