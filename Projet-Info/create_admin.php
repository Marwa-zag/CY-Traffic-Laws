<?php
session_start();

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "root";
$database = "projet_info";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

$nom = "Admin";
$prenom = "Super";
$username = "admin";
$email = "admin@example.com";
$password = "admin_password";
$birthdate = "2000-01-01";
$role = "admin";

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("SELECT id FROM users WHERE role = 'admin' LIMIT 1");
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    echo "Un compte administrateur existe déjà.";
    $stmt->close();
    $conn->close();
    exit();
}
$stmt->close();

$stmt = $conn->prepare("INSERT INTO users (nom, prenom, username, email, mdp, birthdate, role) VALUES (?, ?, ?, ?, ?, ?, ?)");
if ($stmt === false) {
    die('Erreur lors de la préparation de la requête : ' . htmlspecialchars($conn->error));
}

$stmt->bind_param('sssssss', $nom, $prenom, $username, $email, $hashed_password, $birthdate, $role);

if ($stmt->execute()) {
    $_SESSION['is_admin'] = true;
    echo "Vous êtes maintenant connecté en tant qu'administrateur.";
} else {
    echo "Erreur lors de la création du compte administrateur : " . htmlspecialchars($stmt->error);
}
$stmt->close();
$conn->close();
?>
