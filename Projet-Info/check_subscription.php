<?php
session_start(); // Démarrage de la session
header('Content-Type: application/json'); // Définition du type de contenu de la réponse comme JSON

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['is_premium' => false]); // Si non connecté, retourne false pour is_premium
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
    echo json_encode(['is_premium' => false, 'error' => 'Erreur de connexion à la base de données']); // Si erreur de connexion, retourne false pour is_premium avec un message d'erreur
    exit();
}

$sql = "SELECT is_premium FROM users WHERE id = ?"; // Requête pour vérifier si l'utilisateur a un abonnement premium
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id); // Liaison de l'ID utilisateur
$stmt->execute();
$stmt->bind_result($is_premium); // Liaison du résultat
$stmt->fetch();

echo json_encode(['is_premium' => $is_premium]); // Retourne le statut premium de l'utilisateur

$stmt->close();
$conn->close();
?>
