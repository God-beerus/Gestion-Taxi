<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: connexion.php");
    exit;
}

$vehicule_id = $_GET['id'];

$conn = new mysqli("localhost", "root", "", "gestion_taxi");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM vehicules WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $vehicule_id);
$stmt->execute();
$result = $stmt->get_result();
$vehicule = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modifier un véhicule</title>
</head>
<body>
    <h2>Modifier un véhicule</h2>
    <form action="traitement_modification_vehicule.php" method="post">
        <input type="hidden" name="id" value="<?php echo $vehicule['id']; ?>">
        <label for="marque">Marque:</label>
        <input type="text" id="marque" name="marque" value="<?php echo $vehicule['marque']; ?>" required><br>
        <label for="modele">Modèle:</label>
        <input type="text" id="modele" name="modele" value="<?php echo $vehicule['modele']; ?>" required><br>
        <label for="plaque_immatriculation">Plaque d'immatriculation:</label>
        <input type="text" id="plaque_immatriculation" name="plaque_immatriculation" value="<?php echo $vehicule['plaque_immatriculation']; ?>" required><br>
        <label for="date_achat">Date d'achat:</label>
        <input type="date" id="date_achat" name="date_achat" value="<?php echo $vehicule['date_achat']; ?>" required><br>
        <button type="submit">Modifier</button>
    </form>
    <a href="vehicules.php">Retour</a>
</body>
</html>
