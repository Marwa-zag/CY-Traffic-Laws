<?php
// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=projet_info', 'root', 'root');

// Récupérer le score depuis le formulaire
$score = $_POST['score'];

// Enregistrer le score dans la base de données
// Supposons que l'ID de l'utilisateur soit stocké dans une variable de session appelée 'utilisateur_id'
$utilisateur_id = $_SESSION['utilisateur_id'];

// Exemple d'une requête d'insertion :
$query = "INSERT INTO scores (utilisateur_id, score) VALUES (:utilisateur_id, :score)";
$statement = $pdo->prepare($query);
$statement->execute(['utilisateur_id' => $utilisateur_id, 'score' => $score]);

// Redirection vers la page de scores
header('Location: score.html');
?>

