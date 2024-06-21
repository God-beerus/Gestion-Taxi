<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $vehicule_id = $_POST['vehicule_id'];
    $description = $_POST['description'];
    $cout = $_POST['cout'];
    $date = $_POST['date'];

    $conn = new mysqli("localhost", "root", "", "gestion_taxi");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE maintenances SET vehicule_id = ?, description = ?, cout = ?, date = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isdsi", $vehicule_id, $description, $cout, $date, $id);

    if ($stmt->execute()) {
        header("Location: maintenances.php");
    } else {
        echo "Erreur: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
