<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des chauffeurs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }
        a.button {
            display: inline-block;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e2e6ea;
        }
        td.actions a {
            margin-right: 10px;
            color: #007bff;
            text-decoration: none;
        }
        td.actions a:hover {
            text-decoration: underline;
        }
        a.back {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #007bff;
            text-decoration: none;
        }
        a.back:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Gestion des chauffeurs</h2>
        <a class="button" href="ajouter_chauffeur.php">Ajouter un chauffeur</a>
        <table>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Adresse</th>
                <th>Téléphone</th>
                <th>Véhicule</th>
                <th>Plaque d'immatriculation</th>
                <th>Actions</th>
            </tr>
            <?php
            session_start();

            $conn = new mysqli("localhost", "root", "", "gestion_taxi");

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT chauffeurs.id, chauffeurs.Nom, chauffeurs.Adresse, chauffeurs.Téléphone, vehicules.marque, vehicules.plaque_immatriculation FROM chauffeurs LEFT JOIN vehicules ON chauffeurs.vehicule_id = vehicules.id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['Nom'] . "</td>";
                    echo "<td>" . $row['Adresse'] . "</td>";
                    echo "<td>" . $row['Téléphone'] . "</td>";
                    echo "<td>" . $row['marque'] . "</td>";
                    echo "<td>" . $row['plaque_immatriculation'] . "</td>";
                    echo "<td class='actions'><a href='modifier_chauffeur.php?id=" . $row['id'] . "'>Modifier</a> | <a href='supprimer_chauffeur.php?id=" . $row['id'] . "'>Supprimer</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Aucun chauffeur trouvé.</td></tr>";
            }
            ?>
        </table>
        <a class="back" href="tableau_de_bord.php">Retour</a>
    </div>
</body>
</html>
