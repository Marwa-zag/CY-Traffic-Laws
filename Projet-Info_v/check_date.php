<?php
$servername = "localhost";
$db_username = "root";
$db_password = "root";
$database = "projet_info";

// Récupération de la date depuis la requête GET
$date = $_GET['date'];

$conn = new mysqli($servername, $db_username, $db_password, $database);
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . htmlspecialchars($conn->connect_error));
}

// Requête SQL pour vérifier la disponibilité de la date
$sql = "SELECT COUNT(*) AS count FROM reservations WHERE date = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $date);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Création de la réponse JSON indiquant la disponibilité de la date
$response = array("available" => $row['count'] == 0);
echo json_encode($response);

$stmt->close();
$conn->close();
?>
