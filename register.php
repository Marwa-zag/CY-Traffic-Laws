<<?php
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
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $genre = $_POST['Genre'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $mdp = password_hash($_POST['password'], PASSWORD_DEFAULT); // Correction ici pour utiliser $mdp
    $birthdate = $_POST['birthdate'];
    $profile_pic = 'default.png'; // Default profile picture
    
    $stmt = $conn->prepare("INSERT INTO users (nom, prenom, genre, email, username, mdp, birthdate, profile_pic) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Erreur de préparation de la requête : " . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("ssssssss", $nom, $prenom, $genre, $email, $username, $mdp, $birthdate, $profile_pic);
    
    if ($stmt->execute()) {
        // Get the user's ID
        $user_id = $stmt->insert_id;

        // Start a session for the new user
        $_SESSION['user_id'] = $user_id;
        $_SESSION['prenom'] = $prenom;
        $_SESSION['is_premium'] = false;
        $_SESSION['is_admin'] = false;

        // Redirect to the home page or dashboard
        header("Location: projet.html");
        exit();
    } else {
        echo "Erreur : " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
