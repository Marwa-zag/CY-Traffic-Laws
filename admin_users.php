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

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . htmlspecialchars($conn->connect_error));
}

$action = isset($_POST['action']) ? $_POST['action'] : '';
$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;

switch ($action) {
    case 'delete':
        // Supprimer les messages de l'utilisateur dans le forum
        $delete_posts_query = "DELETE FROM forum_posts WHERE user_id = $user_id";
        if ($conn->query($delete_posts_query) !== TRUE) {
            $_SESSION['message'] = "Erreur lors de la suppression des messages de l'utilisateur dans le forum : " . htmlspecialchars($conn->error);
            header("Location: manage_users.php");
            exit();
        }

        // Supprimer l'utilisateur de la base de données
        $delete_user_query = "DELETE FROM users WHERE id = $user_id";
        if ($conn->query($delete_user_query) === TRUE) {
            $_SESSION['message'] = "Utilisateur supprimé avec succès.";
        } else {
            $_SESSION['message'] = "Erreur lors de la suppression de l'utilisateur : " . htmlspecialchars($conn->error);
        }
        break;
    case 'deactivate':
        $query = "UPDATE users SET active = 0 WHERE id = $user_id";
        if ($conn->query($query) === TRUE) {
            $_SESSION['message'] = "Utilisateur désactivé avec succès.";
        } else {
            $_SESSION['message'] = "Erreur lors de la désactivation de l'utilisateur : " . htmlspecialchars($conn->error);
        }
        break;
    case 'activate':
        $query = "UPDATE users SET active = 1 WHERE id = $user_id";
        if ($conn->query($query) === TRUE) {
            $_SESSION['message'] = "Utilisateur activé avec succès.";
        } else {
            $_SESSION['message'] = "Erreur lors de l'activation de l'utilisateur : " . htmlspecialchars($conn->error);
        }
        break;
    default:
        $_SESSION['message'] = "Action non reconnue.";
        header("Location: manage_users.php");
        exit();
}

$conn->close();
header("Location: manage_users.php");
exit();
?>