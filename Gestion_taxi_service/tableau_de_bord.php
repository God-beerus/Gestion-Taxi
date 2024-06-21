<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
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
            color: #333;
        }
        .welcome {
            text-align: right;
            margin-bottom: 20px;
        }
        .welcome a {
            color: #007bff;
            text-decoration: none;
            margin-left: 10px;
        }
        .welcome a:hover {
            text-decoration: underline;
        }
        .links {
            text-align: center;
            margin-top: 50px;
        }
        .links a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            margin: 0 10px;
            transition: background-color 0.3s;
        }
        .links a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Dashboard</h2>
        <div class="welcome">
            <?php
            session_start();
            
            if (!isset($_SESSION['chauffeur_id'])) {
                header("Location: connexion.php");
                exit;
            }
            
            echo "Bienvenue, " . $_SESSION['nom'];
            ?>
            <a href="deconnexion.php">Se déconnecter</a>
        </div>
        <div class="links">
            <a href="chauffeurs.php">Gérer les Chauffeurs</a>
            <a href="vehicules.php">Gérer les Véhicules</a>
            <a href="rapports.php">Générer des Rapports</a>
            <a href="inscription.php">Inscription de Nouveaux Utilisateurs</a>
            <a href="ajouter_depot.php">Ajouter des recettes</a>
            <a href="salaire.php">Salaire</a>
        </div>
    </div>
</body>
</html>
