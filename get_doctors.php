<?php
require_once "config/database.php";

$service_id = $_GET["service_id"] ?? 0;

$stmt = $conn->prepare("
    SELECT doctors.*
    FROM doctors
    JOIN doctor_services 
        ON doctors.id = doctor_services.doctor_id
    WHERE doctor_services.service_id = ?
");

$stmt->bind_param("i", $service_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<option disabled>Nincs elérhető orvos</option>";
    exit();
}

while ($row = $result->fetch_assoc()) {
    echo "<option value='{$row["id"]}'>{$row["name"]} ({$row["specialization"]})</option>";
}