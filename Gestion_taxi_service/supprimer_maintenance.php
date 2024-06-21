<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: connexion.php");
    exit;
}

$maintenance_id = $_GET['id'];

$conn = new mysqli("localhost", "root", "", "gestion_taxi");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "DELETE FROM maintenances WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $maintenance_id);

if ($stmt->execute()) {
    header("Location: maintenances.php");
} else {
    echo "Erreur: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
