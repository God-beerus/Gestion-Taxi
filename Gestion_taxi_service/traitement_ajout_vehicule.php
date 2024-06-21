<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $marque = $_POST['marque'];
    $modele = $_POST['modele'];
    $plaque_immatriculation = $_POST['plaque_immatriculation'];
    $date_achat = $_POST['date_achat'];

    $conn = new mysqli("localhost", "root", "", "gestion_taxi");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO vehicules (marque, modele, plaque_immatriculation, date_achat) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $marque, $modele, $plaque_immatriculation, $date_achat);

    if ($stmt->execute()) {
        header("Location: vehicules.php");
    } else {
        echo "Erreur: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
