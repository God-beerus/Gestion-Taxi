<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un véhicule</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }
        form {
            width: 50%;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
        }
        input[type="text"],
        input[type="date"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            cursor: pointer;
        }
        button[type="submit"]:hover {
            background-color: #0056b3;
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
    <h2>Ajouter un véhicule</h2>
    <form action="traitement_ajout_vehicule.php" method="post">
        <label for="marque">Marque:</label>
        <input type="text" id="marque" name="marque" required><br>
        <label for="modele">Modèle:</label>
        <input type="text" id="modele" name="modele" required><br>
        <label for="plaque_immatriculation">Plaque d'immatriculation:</label>
        <input type="text" id="plaque_immatriculation" name="plaque_immatriculation" required><br>
        <label for="date_achat">Date d'achat:</label>
        <input type="date" id="date_achat" name="date_achat" required><br>
        <button type="submit">Ajouter</button>
    </form>
    <a class="back" href="vehicules.php">Retour</a>
</body>
</html>
