<?php
// Démarrage de la session PHP pour accéder aux variables de session
session_start();

// Paramètres de connexion à la base de données MySQL
$servername = "localhost";
$username = "root";
$password = "root";
$database = "projet_info";

// Connexion à la base de données MySQL
$conn = new mysqli($servername, $username, $password, $database);

// Vérification de la connexion à la base de données
if ($conn->connect_error) {
    // Affichage d'un message d'erreur si la connexion échoue
    die("Erreur de connexion à la base de données : " . htmlspecialchars($conn->connect_error));
}

// Vérification si la méthode de requête est POST (utilisée pour soumettre le formulaire d'inscription)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération et nettoyage des données du formulaire
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $genre = trim($_POST['Genre']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];
    $birthdate = trim($_POST['birthdate']);
    $profile_pic = 'default.png'; // Image de profil par défaut

    // Vérification si les mots de passe saisis correspondent
    if ($password !== $confirm_password) {
        // Affichage d'une alerte et redirection vers la page d'inscription en cas de non-correspondance
        echo "<script>alert('Les mots de passe ne correspondent pas !'); window.location.href = 'register.html';</script>";
        exit();
    }
    
    // Vérification des conditions du mot de passe
    if (strlen($password) < 8 || !preg_match("/[a-z]/", $password) ||
        !preg_match("/[A-Z]/", $password) || !preg_match("/[0-9]/", $password) ||
        !preg_match("/[!@#$%^&*(),.?\":{}|<>]/", $password)) {
        // Affichage d'une alerte et redirection vers la page d'inscription en cas de mot de passe invalide
        echo "<script>alert('Le mot de passe doit contenir au moins 8 caractères, une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.'); window.location.href = 'register.html';</script>";
        exit();
    }

    // Hashage du mot de passe avant de le stocker en base de données
    $mdp = password_hash($password, PASSWORD_DEFAULT);

    // Préparation de la requête SQL pour insérer un nouvel utilisateur dans la base de données
    $stmt = $conn->prepare("INSERT INTO users (nom, prenom, genre, email, username, mdp, birthdate, profile_pic) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        // Affichage d'une erreur en cas de problème avec la préparation de la requête
        die("Erreur de préparation de la requête : " . htmlspecialchars($conn->error));
    }
    // Liaison des paramètres à la requête SQL
    $stmt->bind_param("ssssssss", $nom, $prenom, $genre, $email, $username, $mdp, $birthdate, $profile_pic);

    // Exécution de la requête SQL d'insertion
    if ($stmt->execute()) {
        // Récupération de l'ID de l'utilisateur nouvellement inséré
        $user_id = $stmt->insert_id;

        // Stockage des informations de l'utilisateur dans la session
        $_SESSION['user_id'] = $user_id;
        $_SESSION['prenom'] = $prenom;
        $_SESSION['is_premium'] = false;
        $_SESSION['is_admin'] = false;

        // Redirection vers la page du projet après l'inscription
        header("Location: projet.html");
        exit();
    } else {
        // Affichage d'une erreur en cas d'échec de l'exécution de la requête
        echo "Erreur : " . htmlspecialchars($stmt->error);
    }

    // Fermeture du statement SQL
    $stmt->close();
}

// Fermeture de la connexion à la base de données
$conn->close();
?>
