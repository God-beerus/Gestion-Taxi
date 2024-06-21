<?php
session_start();

// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "gestion_taxi");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Requête pour récupérer les données des chauffeurs
$sql_chauffeurs = "SELECT id, nom FROM chauffeurs";
$stmt_chauffeurs = $conn->prepare($sql_chauffeurs);
$stmt_chauffeurs->execute();
$chauffeurs = $stmt_chauffeurs->get_result();

// Traitement du formulaire de sélection du mois et de l'année
$chauffeur_id = isset($_GET['chauffeur_id']) ? $_GET['chauffeur_id'] : '';
$mois = isset($_GET['mois']) ? $_GET['mois'] : date("Y-m");

// Requête pour récupérer les données financières
$sql_financieres = "SELECT c.nom, SUM(COALESCE(d.montant, 0)) AS total_revenu, SUM(COALESCE(m.cout, 0)) AS total_cout
                    FROM chauffeurs c
                    LEFT JOIN depots d ON c.id = d.chauffeur_id AND DATE_FORMAT(d.date, '%Y-%m') = ?
                    LEFT JOIN vehicules v ON c.vehicule_id = v.id
                    LEFT JOIN maintenances m ON v.id = m.vehicule_id AND DATE_FORMAT(m.date, '%Y-%m') = ?
                    WHERE c.id = IF(? = '', c.id, ?)
                    GROUP BY c.id";
$stmt_financieres = $conn->prepare($sql_financieres);
$stmt_financieres->bind_param("ssii", $mois, $mois, $chauffeur_id, $chauffeur_id);
$stmt_financieres->execute();
$result_financieres = $stmt_financieres->get_result();

// Fermeture des connexions et des requêtes
$stmt_chauffeurs->close();
$stmt_financieres->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapports financiers</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <h2>Rapports financiers</h2>
        <!-- Formulaire de filtrage par chauffeur et mois -->
        <form method="get" action="rapports.php">
            <label for="chauffeur_id">Chauffeur:</label>
            <select id="chauffeur_id" name="chauffeur_id">
                <option value="">Tous</option>
                <?php
                while ($row = $chauffeurs->fetch_assoc()) {
                    $selected = ($row['id'] == $chauffeur_id) ? "selected" : "";
                    echo "<option value='" . $row['id'] . "' $selected>" . $row['nom'] . "</option>";
                }
                ?>
            </select>
            <label for="mois">Mois:</label>
            <input type="month" id="mois" name="mois" value="<?php echo $mois; ?>">
            <button type="submit">Filtrer</button>
        </form>
        
        <!-- Tableau des rapports financiers -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Chauffeur</th>
                    <th>Total Revenu</th>
                    <th>Total Dépenses</th>
                    <th>Profit</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_financieres->num_rows > 0) {
                    while ($row = $result_financieres->fetch_assoc()) {
                        $profit = $row['total_revenu'] - $row['total_cout'];
                        echo "<tr>";
                        echo "<td>" . $row['nom'] . "</td>";
                        echo "<td>" . $row['total_revenu'] . "</td>";
                        echo "<td>" . $row['total_cout'] . "</td>";
                        echo "<td>" . $profit . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Aucun résultat trouvé.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        
        <!-- Graphique des revenus par chauffeur -->
        <canvas id="myChart"></canvas>
        
        <a href="tableau_de_bord.php" class="btn btn-primary">Retour</a>
    </div>
    
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    <?php
                    $result_financieres->data_seek(0);
                    while ($row = $result_financieres->fetch_assoc()) {
                        echo "'" . $row['nom'] . "',";
                    }
                    ?>
                ],
                datasets: [{
                    label: 'Total Revenu',
                    data: [
                        <?php
                        $result_financieres->data_seek(0);
                        while ($row = $result_financieres->fetch_assoc()) {
                            echo $row['total_revenu'] . ",";
                        }
                        ?>
                    ],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
