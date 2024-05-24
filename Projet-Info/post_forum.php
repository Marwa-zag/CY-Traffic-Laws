<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(['success' => false, 'message' => 'Vous devez être connecté pour envoyer un message.', 'debug' => $_SESSION]);
    exit();
}

// Connexion à la base de données
$conn = new mysqli('localhost', 'root', 'root', 'projet_info');

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erreur de connexion à la base de données.']);
    exit();
}

// Vérifier si le contenu du message est envoyé
$content = file_get_contents('php://input');
$data = json_decode($content, true);

if (!isset($data['content']) || empty(trim($data['content']))) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Le contenu du message ne peut pas être vide.']);
    exit();
}

$content = trim($data['content']);
$user_id = $_SESSION['user_id'];

// Préparer la requête SQL
$stmt = $conn->prepare("INSERT INTO forum_posts (user_id, content, created_at) VALUES (?, ?, NOW())");
$stmt->bind_param("is", $user_id, $content);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Message envoyé avec succès.']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'envoi du message: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>