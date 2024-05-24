<?php
session_start();
$response = array();

$servername = "localhost";
$username = "root";
$password = "root";
$database = "projet_info";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . htmlspecialchars($conn->connect_error));
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $response['user_id'] = $user_id;
    $response['prenom'] = $_SESSION['prenom'];
    $response['is_premium'] = isset($_SESSION['is_premium']) && $_SESSION['is_premium'];
    $response['is_admin'] = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];

    $stmt = $conn->prepare("SELECT profile_pic FROM users WHERE id = ?");
    if ($stmt === false) {
        die("Erreur de préparation de la requête : " . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($profile_pic);
    $stmt->fetch();
    $stmt->close();

    $response['profile_pic'] = $profile_pic ? $profile_pic : 'default.png';
} 

$conn->close();

echo json_encode($response);
?>
