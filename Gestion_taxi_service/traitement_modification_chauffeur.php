<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    $conn = new mysqli("localhost", "root", "", "gestion_taxi");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (!empty($mot_de_passe)) {
        $mot_de_passe = password_hash($mot_de_passe, PASSWORD_DEFAULT);
        $sql = "UPDATE chauffeurs SET nom = ?, email = ?, mot_de_passe = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $nom, $email, $mot_de_passe, $id);
    } else {
        $sql = "UPDATE chauffeurs SET nom = ?, email = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $nom, $email, $id);
    }

    if ($stmt->execute()) {
        header("Location: chauffeurs.php");
    } else {
        echo "Erreur: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
