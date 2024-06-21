
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un chauffeur</title>
    <style>
         body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 400px;
            margin: 100px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        input[type="text"],
        input[type="tel"] {
            width: calc(100% - 10px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h2>Ajouter un chauffeur</h2>
    <form action="traitement_ajout_chauffeur.php" method="post">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required><br>
        <label for="adresse">Adresse :</label>
        <input type="text" id="adresse" name="adresse" required><br>
        <label for="telephone">Téléphone :</label>
        <input type="tel" id="telephone" name="telephone" required><br>
        <label for="vehicule_id">Véhicule:</label>
        <select id="vehicule_id" name="vehicule_id" required>
            <?php
            $conn = new mysqli("localhost", "root", "", "gestion_taxi");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "SELECT id, plaque_immatriculation FROM vehicules";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['plaque_immatriculation'] . "</option>";
                }
            }
            $conn->close();
            ?>
        </select><br>
        <button type="submit">Ajouter</button>
    </form>
</body>
</html>
