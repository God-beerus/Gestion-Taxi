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

$sql = "SELECT nom, email FROM chauffeurs WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $chauffeur_id);
$stmt->execute();
$result = $stmt->get_result();

$chauffeur = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Mon Profil</h2>
        <table class="table table-bordered">
            <tr>
                <th>Nom</th>
                <td><?php echo $chauffeur['nom']; ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo $chauffeur['email']; ?></td>
            </tr>
        </table>
        <a href="tableau_de_bord.php" class="btn btn-primary">Retour</a>
    </div>
</body>
</html>
