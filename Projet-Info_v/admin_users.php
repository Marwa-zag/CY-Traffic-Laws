<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Vérifier si l'utilisateur est administrateur
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: login.html");
    exit();
}

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "root";
$database = "projet_info";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $database);

// Vérifie si la connexion à la base de données a échoué
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . htmlspecialchars($conn->connect_error));
}

// Récupération de l'action et de l'ID de l'utilisateur à partir des données POST
$action = isset($_POST['action']) ? $_POST['action'] : '';
$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;

// Switch sur l'action à effectuer
switch ($action) {
    case 'delete':
        // Supprimer les réservations de l'utilisateur
        $delete_reservations_query = "DELETE FROM reservations WHERE user_id = ?";
        $stmt = $conn->prepare($delete_reservations_query);
        $stmt->bind_param("i", $user_id);
        if (!$stmt->execute()) {
            $_SESSION['message'] = "Erreur lors de la suppression des réservations de l'utilisateur : " . htmlspecialchars($stmt->error);
            header("Location: manage_users.php");
            exit();
        }
        $stmt->close();

        // Supprimer les messages de l'utilisateur dans le forum
        $delete_posts_query = "DELETE FROM forum_posts WHERE user_id = ?";
        $stmt = $conn->prepare($delete_posts_query);
        $stmt->bind_param("i", $user_id);
        if (!$stmt->execute()) {
            $_SESSION['message'] = "Erreur lors de la suppression des messages de l'utilisateur dans le forum : " . htmlspecialchars($stmt->error);
            header("Location: manage_users.php");
            exit();
        }
        $stmt->close();

        // Supprimer l'utilisateur de la base de données
        $delete_user_query = "DELETE FROM users WHERE id = ?";
        $stmt = $conn->prepare($delete_user_query);
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Utilisateur supprimé avec succès.";
        } else {
            $_SESSION['message'] = "Erreur lors de la suppression de l'utilisateur : " . htmlspecialchars($stmt->error);
        }
        $stmt->close();
        break;
    case 'deactivate':
        $query = "UPDATE users SET active = 0 WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Utilisateur désactivé avec succès.";
        } else {
            $_SESSION['message'] = "Erreur lors de la désactivation de l'utilisateur : " . htmlspecialchars($stmt->error);
        }
        $stmt->close();
        break;
    case 'activate':
        $query = "UPDATE users SET active = 1 WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Utilisateur activé avec succès.";
        } else {
            $_SESSION['message'] = "Erreur lors de l'activation de l'utilisateur : " . htmlspecialchars($stmt->error);
        }
        $stmt->close();
        break;
    default:
        $_SESSION['message'] = "Action non reconnue.";
        header("Location: manage_users.php");
        exit();
}

// Fermeture de la connexion à la base de données
$conn->close();

// Redirection vers la page de gestion des utilisateurs
header("Location: manage_users.php");
exit();
?>
