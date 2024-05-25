<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "root";
$database = "projet_info";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . htmlspecialchars($conn->connect_error));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $genre = trim($_POST['Genre']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];
    $birthdate = trim($_POST['birthdate']);
    $profile_pic = 'default.png'; // Default profile picture

    // Vérification des conditions du mot de passe
    if ($password !== $confirm_password) {
        echo "<script>alert('Les mots de passe ne correspondent pas !'); window.location.href = 'register.html';</script>";
        exit();
    }
    
    if (strlen($password) < 8 || !preg_match("/[a-z]/", $password) ||
        !preg_match("/[A-Z]/", $password) || !preg_match("/[0-9]/", $password) ||
        !preg_match("/[!@#$%^&*(),.?\":{}|<>]/", $password)) {
        echo "<script>alert('Le mot de passe doit contenir au moins 8 caractères, une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.'); window.location.href = 'register.html';</script>";
        exit();
    }

    $mdp = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (nom, prenom, genre, email, username, mdp, birthdate, profile_pic) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Erreur de préparation de la requête : " . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("ssssssss", $nom, $prenom, $genre, $email, $username, $mdp, $birthdate, $profile_pic);

    if ($stmt->execute()) {
        $user_id = $stmt->insert_id;

        $_SESSION['user_id'] = $user_id;
        $_SESSION['prenom'] = $prenom;
        $_SESSION['is_premium'] = false;
        $_SESSION['is_admin'] = false;

        header("Location: projet.html");
        exit();
    } else {
        echo "Erreur : " . htmlspecialchars($stmt->error);
    }

    $stmt->close();
}

$conn->close();
?>
