<?php
session_start(); // Démarrage de la session

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html"); // Redirection vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}

$user_id = $_SESSION['user_id']; // Récupération de l'ID de l'utilisateur depuis la session
$servername = "localhost";
$db_username = "root";
$db_password = "root";
$database = "projet_info";

$conn = new mysqli($servername, $db_username, $db_password, $database); // Connexion à la base de données

// Vérification de la connexion
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . htmlspecialchars($conn->connect_error));
}

$sql = "SELECT is_premium FROM users WHERE id = ?"; // Requête pour vérifier si l'utilisateur a un abonnement premium
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id); // Liaison de l'ID utilisateur
$stmt->execute();
$stmt->bind_result($is_premium); // Liaison du résultat
$stmt->fetch();

$stmt->close();
$conn->close();

// Redirection en fonction du statut premium de l'utilisateur
if ($is_premium) {
    header("Location: plus.html");
} else {
    header("Location: premium.html");
}
exit();
?>
