<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: connexion.php");
    exit;
}

$chauffeur_id = $_GET['id'];

$conn = new mysqli("localhost", "root", "", "gestion_taxi");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM chauffeurs WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $chauffeur_id);
$stmt->execute();
$result = $stmt->get_result();
$chauffeur = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modifier un chauffeur</title>
</head>
<body>
    <h2>Modifier un chauffeur</h2>
    <form action="traitement_modification_chauffeur.php" method="post">
        <input type="hidden" name="id" value="<?php echo $chauffeur['id']; ?>">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" value="<?php echo $chauffeur['nom']; ?>" required><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $chauffeur['email']; ?>" required><br>
        <label for="mot_de_passe">Mot de passe:</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe"><br>
        <button type="submit">Modifier</button>
    </form>
    <a href="chauffeurs.php">Retour</a>
</body>
</html>
