<?php
// Démarrage de la session PHP pour accéder aux variables de session
session_start();

// Initialisation d'un tableau pour stocker les données à renvoyer sous forme JSON
$response = array();

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

// Vérification si une session utilisateur est active
if (isset($_SESSION['user_id'])) {
    // Récupération de l'ID de l'utilisateur depuis la session
    $user_id = $_SESSION['user_id'];
    // Stockage de l'ID de l'utilisateur dans le tableau de réponse
    $response['user_id'] = $user_id;
    // Récupération du prénom de l'utilisateur depuis la session et stockage dans le tableau de réponse
    $response['prenom'] = $_SESSION['prenom'];
    // Vérification si l'utilisateur est premium et stockage dans le tableau de réponse
    $response['is_premium'] = isset($_SESSION['is_premium']) && $_SESSION['is_premium'];
    // Vérification si l'utilisateur est administrateur et stockage dans le tableau de réponse
    $response['is_admin'] = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];

    // Préparation d'une requête SQL paramétrée pour récupérer l'URL de la photo de profil de l'utilisateur
    $stmt = $conn->prepare("SELECT profile_pic FROM users WHERE id = ?");
    // Vérification si la préparation de la requête a échoué
    if ($stmt === false) {
        // Affichage d'un message d'erreur si la préparation de la requête échoue
        die("Erreur de préparation de la requête : " . htmlspecialchars($conn->error));
    }
    // Liaison du paramètre user_id à la requête SQL
    $stmt->bind_param("i", $user_id);
    // Exécution de la requête
    $stmt->execute();
    // Liaison du résultat de la requête à une variable
    $stmt->bind_result($profile_pic);
    // Récupération du résultat de la requête
    $stmt->fetch();
    // Fermeture du statement SQL
    $stmt->close();

    // Attribution de l'URL de la photo de profil à la clé profile_pic du tableau de réponse
    // Si aucune photo de profil n'est trouvée, utilise 'default.png' comme valeur par défaut
    $response['profile_pic'] = $profile_pic ? $profile_pic : 'default.png';
} 

// Fermeture de la connexion à la base de données
$conn->close();

// Encodage du tableau de réponse en JSON et affichage du résultat
echo json_encode($response);
?>
