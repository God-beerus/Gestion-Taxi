<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $adresse = $_POST['adresse'];
    $telephone = $_POST['telephone'];
    $vehicule_id = $_POST['vehicule_id']; // Récupération de l'ID du véhicule sélectionné dans le menu déroulant

    $conn = new mysqli("localhost", "root", "", "gestion_taxi");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO chauffeurs (Nom, Adresse, Téléphone, vehicule_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nom, $adresse, $telephone, $vehicule_id); // Modification de la liste des paramètres à lier

    if ($stmt->execute()) {
        header("Location: chauffeurs.php");
    } else {
        echo "Erreur: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
