<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validation des entrées
    if (isset($_POST['email']) && isset($_POST['mot_de_passe'])) {
        $email = trim($_POST['email']);
        $mot_de_passe = trim($_POST['mot_de_passe']);

        // Connexion à la base de données
        $conn = new mysqli("localhost", "root", "", "gestion_taxi");

        // Vérification de la connexion
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Préparation de la requête SQL pour éviter les injections SQL
        $sql = "SELECT id, nom, mot_de_passe FROM utilisateurs WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        // Vérification de l'existence de l'utilisateur
        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $nom, $hashed_password);
            $stmt->fetch();

            // Vérification du mot de passe
            if (password_verify($mot_de_passe, $hashed_password)) {
                // Initialisation des variables de session
                $_SESSION['chauffeur_id'] = $id;
                $_SESSION['nom'] = $nom;
                header("Location: tableau_de_bord.php");
                exit;
            } else {
                $error = "Email ou mot de passe incorrect.";
            }
        } else {
            $error = "Email ou mot de passe incorrect.";
        }

        // Fermeture de la requête et de la connexion
        $stmt->close();
        $conn->close();
    } else {
        $error = "Veuillez entrer un email et un mot de passe.";
    }
}
?>
