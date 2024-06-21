<?php
session_start();

if (!isset($_SESSION['chauffeur_id'])) {
    header("Location: connexion.php");
    exit;
}

$chauffeur_id = $_SESSION['chauffeur_id'];

$conn = new mysqli("localhost", "root", "", "gestion_taxi");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer le nom du chauffeur
$sql_chauffeur = "SELECT nom FROM chauffeurs WHERE id = ?";
$stmt_chauffeur = $conn->prepare($sql_chauffeur);
$stmt_chauffeur->bind_param("i", $chauffeur_id);
$stmt_chauffeur->execute();
$stmt_chauffeur->bind_result($nom_chauffeur);
$stmt_chauffeur->fetch();
$stmt_chauffeur->close();

// Récupérer les dépôts du chauffeur
$sql_depots = "SELECT montant, date FROM depots WHERE chauffeur_id = ? ORDER BY date DESC";
$stmt_depots = $conn->prepare($sql_depots);
$stmt_depots->bind_param("i", $chauffeur_id);
$stmt_depots->execute();
$result = $stmt_depots->get_result();
$stmt_depots->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dépôts de <?php echo $nom_chauffeur; ?></title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Dépôts de <?php echo $nom_chauffeur; ?></h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Montant</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . number_format($row['montant'], 2) . " FCFA</td>";
                        echo "<td>" . $row['date'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>Aucun dépôt trouvé</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="tableau_de_bord.php" class="btn btn-primary">Retour</a>
    </div>
</body>
</html>





