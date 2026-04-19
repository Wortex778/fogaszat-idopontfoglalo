<?php
require_once "config/database.php";

$id = $_GET["id"];

$stmt = $conn->prepare("SELECT * FROM services WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$service = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $service["name"]; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">
    <a href="dashboard.php" class="logo">🦷 Fogászat</a>
</nav>

<div class="container">

    <h2><?php echo $service["name"]; ?></h2>

    <p><?php echo $service["details"]; ?></p>

    <h3><?php echo $service["price"]; ?> Ft</h3>

    <a href="book.php?service_id=<?php echo $service["id"]; ?>" class="btn">
        Időpont foglalás
    </a>

</div>

</body>
</html>