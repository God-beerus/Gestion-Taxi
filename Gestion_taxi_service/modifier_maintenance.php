<?php
session_start();



$maintenance_id = $_GET['id'];

$conn = new mysqli("localhost", "root", "", "gestion_taxi");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM maintenances WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $maintenance_id);
$stmt->execute();
$result = $stmt->get_result();
$maintenance = $result->fetch_assoc();

$sql = "SELECT id, marque, modele FROM vehicules";
$vehicules = $conn->query($sql);

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modifier une maintenance</title>
</head>
<body>
    <h2>Modifier une maintenance</h2>
    <form action="traitement_modification_maintenance.php" method="post">
        <input type="hidden" name="id" value="<?php echo $maintenance['id']; ?>">
        <label for="vehicule_id">Véhicule:</label>
        <select id="vehicule_id" name="vehicule_id" required>
            <?php
            while ($row = $vehicules->fetch_assoc()) {
                $selected = ($row['id'] == $maintenance['vehicule_id']) ? "selected" : "";
                echo "<option value='" . $row['id'] . "' $selected>" . $row['marque'] . " " . $row['modele'] . "</option>";
            }
            ?>
        </select><br>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?php echo $maintenance['description']; ?></textarea><br>
        <label for="cout">Coût:</label>
        <input type="number" step="0.01" id="cout" name="cout" value="<?php echo $maintenance['cout']; ?>" required><br>
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" value="<?php echo $maintenance['date']; ?>" required><br>
        <button type="submit">Modifier</button>
    </form>
    <a href="maintenances.php">Retour</a>
</body>
</html>
