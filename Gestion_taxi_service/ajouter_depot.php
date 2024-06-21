<?php
session_start();

// Vérification si la méthode de requête est POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $chauffeur_id = $_POST['chauffeur_id'];
    $montant = $_POST['montant'];
    $date = $_POST['date'];

    // Connexion à la base de données
    $conn = new mysqli("localhost", "root", "", "gestion_taxi");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Requête SQL pour insérer le dépôt
    $sql = "INSERT INTO depots (chauffeur_id, montant, date) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ids", $chauffeur_id, $montant, $date);

    // Exécution de la requête
    if ($stmt->execute()) {
        header("Location: depots_chauffeur.php");
    } else {
        echo "Erreur: " . $stmt->error;
    }

    // Fermeture des connexions et des requêtes
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Dépôt</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Ajouter un Dépôt</h2>
        <!-- Formulaire pour ajouter un dépôt -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="chauffeur_id">Chauffeur:</label>
                <select class="form-control" id="chauffeur_id" name="chauffeur_id" required>
                    <?php
                    // Connexion à la base de données
                    $conn = new mysqli("localhost", "root", "", "gestion_taxi");
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Requête SQL pour récupérer les chauffeurs
                    $sql_chauffeurs = "SELECT id, nom FROM chauffeurs";
                    $result_chauffeurs = $conn->query($sql_chauffeurs);

                    // Affichage des options pour les chauffeurs
                    if ($result_chauffeurs->num_rows > 0) {
                        while ($row = $result_chauffeurs->fetch_assoc()) {
                            echo "<option value='" . $row['id'] . "'>" . $row['nom'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>Aucun chauffeur trouvé</option>";
                    }

                    // Fermeture de la connexion
                    $conn->close();
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="montant">Montant:</label>
                <input type="number" step="0.01" class="form-control" id="montant" name="montant" required>
            </div>
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
        <a href="depots_chauffeur.php" class="btn btn-secondary">Retour</a>
    </div>
</body>
</html>
