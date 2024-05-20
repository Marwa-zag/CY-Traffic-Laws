<?php
// Afficher les erreurs PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "root";
$database = "projet_info";
$port = "3306";

$conn = new mysqli($servername, $username, $password, $database, $port);

// Vérifier la connexion
if ($conn->connect_error) {
    echo 'Errno: '.$conn->connect_errno;
    echo '<br>';
    echo 'Error: '.htmlspecialchars($conn->connect_error);
    exit();
}

// Traitement du formulaire d'inscription
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = htmlspecialchars($_POST["nom"]);
    $prenom = htmlspecialchars($_POST["prenom"]);
    $username = htmlspecialchars($_POST["username"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm-password"];
    $birthdate = htmlspecialchars($_POST["birthdate"]);

    // Vérifier si les mots de passe correspondent
    if ($password != $confirm_password) {
        echo "Erreur : Les mots de passe ne correspondent pas.";
        exit();
    }

    // Vérifier la force du mot de passe
    if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password)) {
        echo "Erreur : Le mot de passe doit contenir au moins 8 caractères, dont une majuscule et un chiffre.";
        exit();
    }

    // Vérifier si l'email est déjà utilisé
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo "Erreur : Cet email est déjà utilisé.";
        $stmt->close();
        exit();
    }
    $stmt->close();

    // Hasher le mot de passe
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Préparer la requête d'insertion
    $stmt = $conn->prepare("INSERT INTO users (nom, prenom, username, email, mdp, birthdate) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die('Erreur lors de la préparation de la requête : ' . htmlspecialchars($conn->error));
    }
    // Lier les paramètres
    $stmt->bind_param('ssssss', $nom, $prenom, $username, $email, $hashed_password, $birthdate);

    // Exécuter la requête
    if ($stmt->execute()) {
        // Démarrer une session et définir le prénom
        session_start();
        $_SESSION['prenom'] = $prenom;

        // Rediriger vers la page d'accueil
        header("Location: projet.html");
        exit();
    } else {
        echo "Erreur lors de l'inscription : " . htmlspecialchars($stmt->error);
    }
    // Fermer la requête
    $stmt->close();
}

// Fermer la connexion
$conn->close();
?>
