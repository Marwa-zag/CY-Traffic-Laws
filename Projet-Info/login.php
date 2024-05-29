<?php
session_start();

// Connexion à la base de données
$servername = "localhost";
$db_username = "root";
$db_password = "root";
$database = "projet_info";

$conn = new mysqli($servername, $db_username, $db_password, $database);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . htmlspecialchars($conn->connect_error));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);

    if (!empty($username) && !empty($password)) {
        // Utilisation de requêtes préparées pour éviter les injections SQL
        $stmt = $conn->prepare("SELECT id, prenom, mdp, role, active FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            // Vérification du mot de passe
            if (password_verify($password, $user['mdp'])) {
                if ($user['active'] == 0) {
                    // Le compte est désactivé
                    $_SESSION['user_id'] = $user['id'];
                    header("Location: reactivate_account.php");
                    exit();
                }

                // Mise à jour de la dernière connexion
                $update_stmt = $conn->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
                $update_stmt->bind_param("i", $user['id']);
                $update_stmt->execute();
                $update_stmt->close();

                // L'utilisateur est connecté avec succès
                $_SESSION['prenom'] = $user['prenom'];
                $_SESSION['user_id'] = $user['id'];

                // Vérification si l'utilisateur est un administrateur
                if ($user['role'] == 'admin') {
                    $_SESSION['is_admin'] = true;
                    header("Location: admin_home.php");
                    exit();
                } else {
                    // Redirection vers la page de gestion de compte pour les utilisateurs normaux
                    header("Location: projet.html");
                    exit();
                }
            } else {
                header("Location: login.html?error=Nom d'utilisateur ou mot de passe incorrect.");
                exit();
            }
        } else {
            header("Location: login.html?error=Nom d'utilisateur ou mot de passe incorrect.");
            exit();
        }

        // Fermeture de la connexion
        $stmt->close();
    } else {
        header("Location: login.html?error=Un ou plusieurs champs sont manquants.");
        exit();
    }
}

$conn->close();
?>
