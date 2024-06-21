<?php
session_start();

// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "gestion_taxi");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer la liste des chauffeurs
$sql_chauffeurs = "SELECT id, nom FROM chauffeurs";
$result_chauffeurs = $conn->query($sql_chauffeurs);

// Récupérer les données de revenus mensuels pour chaque chauffeur
$sql_revenus = "
    SELECT c.nom, DATE_FORMAT(d.date, '%Y-%m') AS mois, SUM(d.montant) AS total_revenu
    FROM depots d
    JOIN chauffeurs c ON d.chauffeur_id = c.id
    GROUP BY c.id, mois
    ORDER BY c.id, mois";
$result_revenus = $conn->query($sql_revenus);

$revenus_par_mois = [];
$salaire_par_mois = [];

// Organiser les données par chauffeur et par mois
if ($result_revenus->num_rows > 0) {
    while ($row = $result_revenus->fetch_assoc()) {
        $nom_chauffeur = $row['nom'];
        $mois = $row['mois'];
        $total_revenu = $row['total_revenu'];
        $salaire = $total_revenu * 0.25;

        if (!isset($revenus_par_mois[$nom_chauffeur])) {
            $revenus_par_mois[$nom_chauffeur] = [];
            $salaire_par_mois[$nom_chauffeur] = [];
        }
        $revenus_par_mois[$nom_chauffeur][$mois] = $total_revenu;
        $salaire_par_mois[$nom_chauffeur][$mois] = $salaire;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Calcul du salaire par mois et par chauffeur</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <h2>Calcul du salaire par mois et par chauffeur</h2>
        
        <!-- Tableau des revenus et salaires mensuels par chauffeur -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Chauffeur</th>
                    <th>Mois</th>
                    <th>Revenu Total (FCFA)</th>
                    <th>Salaire (25% du revenu total) (FCFA)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($revenus_par_mois as $nom_chauffeur => $mois_data) {
                    foreach ($mois_data as $mois => $revenu) {
                        $salaire = $salaire_par_mois[$nom_chauffeur][$mois];
                        echo "<tr>";
                        echo "<td>$nom_chauffeur</td>";
                        echo "<td>$mois</td>";
                        echo "<td>" . number_format($revenu, 2) . "</td>";
                        echo "<td>" . number_format($salaire, 2) . "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
        
        <!-- Graphique des revenus et salaires -->
        <canvas id="myChart"></canvas>
        
        <a href="tableau_de_bord.php" class="btn btn-primary">Retour</a>
    </div>
    
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var labels = [];
        var revenusData = [];
        var salairesData = [];
        
        <?php
        $labels = [];
        $revenus_data = [];
        $salaires_data = [];
        
        foreach ($revenus_par_mois as $nom_chauffeur => $mois_data) {
            foreach ($mois_data as $mois => $revenu) {
                $labels[] = "'$nom_chauffeur - $mois'";
                $revenus_data[] = $revenu;
                $salaires_data[] = $salaire_par_mois[$nom_chauffeur][$mois];
            }
        }
        
        echo "labels = [" . implode(", ", $labels) . "];";
        echo "revenusData = [" . implode(", ", $revenus_data) . "];";
        echo "salairesData = [" . implode(", ", $salaires_data) . "];";
        ?>
        
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Revenu Total (FCFA)',
                        data: revenusData,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Salaire (25% du revenu total) (FCFA)',
                        data: salairesData,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }
                ]
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
