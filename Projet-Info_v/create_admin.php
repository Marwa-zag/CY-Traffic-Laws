<?php
session_start();

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "root";
$database = "projet_info";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $database);

// Vérifie si la connexion à la base de données a échoué
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// Informations pour créer le compte administrateur par défaut
$nom = "Admin";
$prenom = "Super";
$admin_username = "admin";
$email = "admin@example.com";
$password = "admin_password";
$birthdate = "2000-01-01";
$role = "admin";

// Hashage du mot de passe
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Vérifie si un compte administrateur existe déjà
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

// Préparation de la requête pour insérer le compte administrateur dans la base de données
$stmt = $conn->prepare("INSERT INTO users (nom, prenom, username, email, mdp, birthdate, role) VALUES (?, ?, ?, ?, ?, ?, ?)");
if ($stmt === false) {
    die('Erreur lors de la préparation de la requête : ' . htmlspecialchars($conn->error));
}

// Liaison des paramètres à la requête préparée
$stmt->bind_param('sssssss', $nom, $prenom, $admin_username, $email, $hashed_password, $birthdate, $role);

// Exécution de la requête pour créer le compte administrateur
if ($stmt->execute()) {
    $_SESSION['is_admin'] = true;
    echo "Vous êtes maintenant connecté en tant qu'administrateur.";
} else {
    echo "Erreur lors de la création du compte administrateur : " . htmlspecialchars($stmt->error);
}

// Fermeture des statements et de la connexion à la base de données
$stmt->close();
$conn->close();
?>
