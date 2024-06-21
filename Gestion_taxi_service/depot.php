<?php
session_start();



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Déposer une somme</title>
</head>
<body>
    <h2>Déposer une somme</h2>
    <form action="traitement_depot.php" method="post">
        <label for="montant">Montant:</label>
        <input type="number" step="0.01" id="montant" name="montant" required><br>
        <button type="submit">Déposer</button>
    </form>
    <a href="tableau_de_bord.php">Retour</a>
</body>
</html>
