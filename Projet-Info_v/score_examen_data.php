<?php
session_start(); // Assure-toi que la session est démarrée pour accéder à $_SESSION

// Connexion à la base de données (à adapter selon ta configuration)
$pdo = new PDO('mysql:host=localhost;dbname=projet_info', 'root', 'root');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Requête pour récupérer les scores de l'utilisateur (à adapter selon ta structure de base de données)
$query = "SELECT date, points FROM scores_examen WHERE utilisateur_id = :utilisateur_id";
$statement = $pdo->prepare($query);
$utilisateur_id = $_SESSION['user_id']; // Récupérer l'ID de l'utilisateur connecté
$statement->bindParam(':utilisateur_id', $utilisateur_id, PDO::PARAM_INT);
$statement->execute();
$scores = $statement->fetchAll(PDO::FETCH_ASSOC);

// Renvoyer les scores au format JSON
header('Content-Type: application/json');
echo json_encode(['scores' => $scores]);
?>