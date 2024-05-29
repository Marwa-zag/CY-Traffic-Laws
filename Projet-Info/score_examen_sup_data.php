<?php
session_start(); 
// Connexion à la base de données 
try {
    $pdo = new PDO('mysql:host=localhost;dbname=projet_info', 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête pour récupérer les scores de l'utilisateur 
    $query = "SELECT date, points FROM scores_premium_examen WHERE utilisateur_id = :utilisateur_id";
    $statement = $pdo->prepare($query);
    $utilisateur_id = $_SESSION['user_id']; // Récupérer l'ID de l'utilisateur connecté
    $statement->bindParam(':utilisateur_id', $utilisateur_id, PDO::PARAM_INT);
    $statement->execute();
    $scores = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Renvoyer les scores au format JSON
    header('Content-Type: application/json');
    echo json_encode(['scores' => $scores]);
} catch (PDOException $e) {
    echo 'Échec lors de la connexion : ' . $e->getMessage();
}
?>