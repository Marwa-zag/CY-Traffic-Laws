<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    die('Utilisateur non authentifié');
}

try {
    // Connexion à la base de données
    $pdo = new PDO('mysql:host=localhost;dbname=projet_info', 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer le score depuis le POST
    $score = isset($_POST['score']) ? (int)$_POST['score'] : 0;
    $user_id = $_SESSION['user_id'];

    // Enregistrer le score dans la base de données
    $query = "INSERT INTO scores_examen (utilisateur_id, points, date) VALUES (:user_id, :score, NOW())";
    $statement = $pdo->prepare($query);
    $statement->execute(['user_id' => $user_id, 'score' => $score]);

    // Répondre avec succès
    http_response_code(200);
    echo json_encode(['message' => 'Score enregistré avec succès']);
} catch (PDOException $e) {
    // Répondre avec une erreur
    http_response_code(500);
    echo json_encode(['message' => 'Erreur : ' . $e->getMessage()]);
}
?>