<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "root";
$database = "projet_info";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . htmlspecialchars($conn->connect_error));
}

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $user_id = $_SESSION['user_id'];

    if ($action === 'update') {
        $prenom = $_POST['prenom'];
        $username = $_POST['username'];
        $email = $_POST['email'];

        $stmt = $conn->prepare("UPDATE users SET prenom = ?, username = ?, email = ? WHERE id = ?");
        if ($stmt === false) {
            die("Erreur de préparation de la requête : " . htmlspecialchars($conn->error));
        }
        $stmt->bind_param("sssi", $prenom, $username, $email, $user_id);
        if ($stmt->execute() === false) {
            die("Erreur lors de l'exécution de la requête : " . htmlspecialchars($stmt->error));
        }
        $stmt->close();
        $_SESSION['message'] = "Informations mises à jour avec succès.";
        header("Location: manage_account.php");
        exit();
    } elseif ($action === 'change_password') {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Vérifiez que les nouveaux mots de passe correspondent
        if ($new_password !== $confirm_password) {
            $_SESSION['message'] = "Les nouveaux mots de passe ne correspondent pas.";
            header("Location: manage_account.php");
            exit();
        }

        // Récupérer le mot de passe actuel de la base de données
        $stmt = $conn->prepare("SELECT mdp FROM users WHERE id = ?");
        if ($stmt === false) {
            die("Erreur de préparation de la requête : " . htmlspecialchars($conn->error));
        }
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Vérifier s'il y a des résultats
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Vérifier le mot de passe actuel
            if (!password_verify($current_password, $user['mdp'])) {
                $_SESSION['message'] = "Le mot de passe actuel est incorrect.";
                header("Location: manage_account.php");
                exit();
            }
        } else {
            // L'utilisateur n'a pas été trouvé
            $_SESSION['message'] = "Erreur: Utilisateur introuvable.";
            header("Location: manage_account.php");
            exit();
        }
        $stmt->close();

        // Mettre à jour avec le nouveau mot de passe
        $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt_update = $conn->prepare("UPDATE users SET mdp = ? WHERE id = ?");
        if ($stmt_update === false) {
            die("Erreur de préparation de la requête : " . htmlspecialchars($conn->error));
        }
        $stmt_update->bind_param("si", $new_password_hashed, $user_id);
        if ($stmt_update->execute() === false) {
            die("Erreur lors de l'exécution de la requête : " . htmlspecialchars($stmt_update->error));
        }
        $stmt_update->close();

        $_SESSION['message'] = "Mot de passe mis à jour avec succès.";
        header("Location: manage_account.php");
        exit();
    } elseif ($action === 'deactivate') {
        $stmt = $conn->prepare("UPDATE users SET active = 0 WHERE id = ?");
        if ($stmt === false) {
            die("Erreur de préparation de la requête : " . htmlspecialchars($conn->error));
        }
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute() === false) {
            die("Erreur lors de l'exécution de la requête : " . htmlspecialchars($stmt->error));
        }
        $stmt->close();
        $_SESSION['message'] = "Compte désactivé avec succès.";
        session_destroy();  // Détruire la session pour déconnecter l'utilisateur
        header("Location: projet.html");
        exit();
    } elseif ($action === 'reactivate') {
        $stmt = $conn->prepare("UPDATE users SET active = 1 WHERE id = ?");
        if ($stmt === false) {
            die("Erreur de préparation de la requête : " . htmlspecialchars($conn->error));
        }
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute() === false) {
            die("Erreur lors de l'exécution de la requête : " . htmlspecialchars($stmt->error));
        }
        $stmt->close();
        $_SESSION['message'] = "Compte réactivé avec succès.";
        header("Location: projet.html");
        exit();
    }
}

$conn->close();
header("Location: manage_account.php");
exit();
?>
