<?php
// Informations de connexion à la base de données
$servername = "localhost";
$db_username = "root";
$db_password = "root";
$database = "projet_info";

// Connexion à la base de données
$conn = new mysqli($servername, $db_username, $db_password, $database);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . htmlspecialchars($conn->connect_error));
}
?>
