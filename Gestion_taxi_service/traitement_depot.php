<?php
session_start();

if (!isset($_SESSION['chauffeur_id'])) {
    header("Location: connexion.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $montant = $_POST['montant'];
    $chauffeur_id = $_SESSION['chauffeur_id'];
    $date = date("Y-m-d");

    $conn = new mysqli("localhost", "root", "", "gestion_taxi");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO depots (chauffeur_id, montant, date) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ids", $chauffeur_id, $montant, $date);

    if ($stmt->execute()) {
        header("Location: tableau_de_bord.php");
    } else {
        echo "Erreur: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
