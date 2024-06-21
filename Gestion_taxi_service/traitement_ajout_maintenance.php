<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vehicule_id = $_POST['vehicule_id'];
    $description = $_POST['description'];
    $cout = $_POST['cout'];
    $date = $_POST['date'];

    $conn = new mysqli("localhost", "root", "", "gestion_taxi");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO maintenances (vehicule_id, description, cout, date) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isds", $vehicule_id, $description, $cout, $date);

    if ($stmt->execute()) {
        header("Location: maintenances.php");
    } else {
        echo "Erreur: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
