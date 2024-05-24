<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['is_premium' => false]);
    exit();
}

$user_id = $_SESSION['user_id'];
$servername = "localhost";
$db_username = "root";
$db_password = "root";
$database = "projet_info";

$conn = new mysqli($servername, $db_username, $db_password, $database);
if ($conn->connect_error) {
    echo json_encode(['is_premium' => false, 'error' => 'Erreur de connexion à la base de données']);
    exit();
}

$sql = "SELECT is_premium FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($is_premium);
$stmt->fetch();

echo json_encode(['is_premium' => $is_premium]);

$stmt->close();
$conn->close();
?>
