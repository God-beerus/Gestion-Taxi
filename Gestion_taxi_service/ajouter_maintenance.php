<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: connexion.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "gestion_taxi");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, marque, modele FROM vehicules";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une maintenance</title>
</head>
<body>
    <h2>Ajouter une maintenance</h2>
    <form action="traitement_ajout_maintenance.php" method="post">
        <label for="vehicule_id">Véhicule:</label>
        <select id="vehicule_id" name="vehicule_id" required>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['marque'] . " " . $row['modele'] . "</option>";
                }
            }
            ?>
        </select><br>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea><br>
        <label for="cout">Coût:</label>
        <input type="number" step="0.01" id="cout" name="cout" required><br>
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required><br>
        <button type="submit">Ajouter</button>
    </form>
    <a href="maintenances.php">Retour</a>
</body>
</html>
<?php
$conn->close();
?>
