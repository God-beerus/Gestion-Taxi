<?php
session_start();


$conn = new mysqli("localhost", "root", "", "gestion_taxi");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT m.id, v.marque, v.modele, m.description, m.cout, m.date FROM maintenances m JOIN vehicules v ON m.vehicule_id = v.id";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gestion des maintenances</title>
</head>
<body>
    <h2>Gestion des maintenances</h2>
    <a href="ajouter_maintenance.php">Ajouter une maintenance</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Véhicule</th>
            <th>Description</th>
            <th>Coût</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['marque'] . " " . $row['modele'] . "</td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "<td>" . $row['cout'] . "</td>";
                echo "<td>" . $row['date'] . "</td>";
                echo "<td><a href='modifier_maintenance.php?id=" . $row['id'] . "'>Modifier</a> | <a href='supprimer_maintenance.php?id=" . $row['id'] . "'>Supprimer</a></td>";
                echo "</tr>";
            }
        }
        ?>
    </table>
    <a href="tableau_de_bord.php">Retour</a>
</body>
</html>
<?php
$conn->close();
?>

















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

$vehicule_id = isset($_GET['vehicule_id']) ? $_GET['vehicule_id'] : '';
$mois = isset($_GET['mois']) ? $_GET['mois'] : date("Y-m");

$sql = "SELECT id, marque, modele FROM vehicules";
$vehicules = $conn->query($sql);

$sql = "SELECT m.id, v.marque, v.modele, m.description, m.cout, m.date
        FROM maintenances m
        JOIN vehicules v ON m.vehicule_id = v.id
        WHERE v.id = IF(? = '', v.id, ?)
        AND DATE_FORMAT(m.date, '%Y-%m') = ?
        ORDER BY m.date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iis", $vehicule_id, $vehicule_id, $mois);
$stmt->execute();
$result = $stmt->get_result();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Maintenances</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Gestion des Maintenances</h2>
        <form method="get" action="maintenances.php">
            <div class="form-group">
                <label for="vehicule_id">Véhicule:</label>
                <select id="vehicule_id" name="vehicule_id" class="form-control">
                    <option value="">Tous</option>
                    <?php
                    while ($row = $vehicules->fetch_assoc()) {
                        $selected = ($row['id'] == $vehicule_id) ? "selected" : "";
                        echo "<option value='" . $row['id'] . "' $selected>" . $row['marque'] . " " . $row['modele'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="mois">Mois:</label>
                <input type="month" id="mois" name="mois" class="form-control" value="<?php echo $mois; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Filtrer</button>
        </form>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Véhicule</th>
                    <th>Description</th>
                    <th>Coût</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['marque'] . " " . $row['modele'] . "</td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td>" . $row['cout'] . "</td>";
                        echo "<td>" . $row['date'] . "</td>";
                        echo "<td>";
                        echo "<a href='modifier_maintenance.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Modifier</a> ";
                        echo "<a href='supprimer_maintenance.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm'>Supprimer</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Aucune maintenance trouvée</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="tableau_de_bord.php" class="btn btn-primary">Retour</a>
    </div>
</body>
</html>
