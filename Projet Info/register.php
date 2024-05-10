<?php
// Connexion   a la base de donnees
$servername = "localhost";
$username = "root";
$password = "root"; // Mot de passe par defaut pour MAMP
$database = "projet_info"; // Remplace "nom_de_ta_base_de_donnees" par le nom de ta base de donnees
$conn = new mysqli($servername, $username, $password, $database);

// Verifier la connexion
if ($conn->connect_error) {
    die("La connexion à la base de donnees a echoue : " . $conn->connect_error);
}

// Traitement du formulaire d'inscription
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $birthdate = $_POST["birthdate"];
    
    // Verifier si les mots de passe correspondent
    if ($password != $confirm_password) {
        echo "Erreur : Les mots de passe ne correspondent pas.";
        exit();
    }
    
    // Hasher le mot de passe
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Inserer les donnees dans la base de donnees
    $sql = "INSERT INTO users (username, email, password, birthdate) VALUES ('$username', '$email', '$hashed_password', '$birthdate')";
    if ($conn->query($sql) === TRUE) {
        echo "Inscription réussie !";
    } else {
        echo "Erreur lors de l'inscription : " . $conn->error;
    }
}

// Fermer la connexion
$conn->close();
?>
