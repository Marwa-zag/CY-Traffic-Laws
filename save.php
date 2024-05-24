<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    die('Utilisateur non authentifié');
}

try {
    // Connexion à la base de données
    $pdo = new PDO('mysql:host=localhost;dbname=projet_info', 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer le score depuis le formulaire
    $score = $_POST['score'];
    $user_id = $_SESSION['user_id'];

    // Enregistrer le score dans la base de données
    $query = "INSERT INTO scores (utilisateur_id, points, date) VALUES (:user_id, :score, NOW())";
    $statement = $pdo->prepare($query);
    $statement->execute(['user_id' => $user_id, 'score' => $score]);

    // Redirection vers la page de scores
    header('Location: score.html');
    exit;
} catch (PDOException $e) {
    echo 'Erreur : ' . $e->getMessage();
}
?>
