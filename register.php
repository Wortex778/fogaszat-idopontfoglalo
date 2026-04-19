<?php
require_once "config/database.php";

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // email ellenőrzés
    $check = $conn->prepare("SELECT id FROM users WHERE email=?");
    $check->bind_param("s", $email);
    $check->execute();
    $res = $check->get_result();

    if ($res->num_rows > 0) {
        $error = "Ez az email már létezik!";
    } else {

        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'user')");
        $stmt->bind_param("sss", $name, $email, $password);

        if ($stmt->execute()) {
            $success = "Sikeres regisztráció! <a href='login.php'>Bejelentkezés</a>";
        } else {
            $error = "Hiba történt!";
        }
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
