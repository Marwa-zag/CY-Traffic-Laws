<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "root";
$database = "projet_info";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . htmlspecialchars($conn->connect_error));
}

$user_id = $_SESSION['user_id'];
$reservation_id = $_POST['reservation_id'];

$sql = "DELETE FROM reservations WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Erreur de préparation de la requête : " . htmlspecialchars($conn->error));
}
$stmt->bind_param("ii", $reservation_id, $user_id);
if ($stmt->execute()) {
    $_SESSION['message'] = "Réservation annulée avec succès.";
} else {
    $_SESSION['message'] = "Erreur lors de l'annulation de la réservation.";
}

$stmt->close();
$conn->close();

header("Location: manage_account.php");
exit();
?>
