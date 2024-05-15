<?php
// Formulaire de connexion
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (!empty($username) && isset($password)) {
        // Connexion à la base de données
        $conn = new mysqli("localhost", "root", "root", "projet_info");

        // Vérification de la connexion
        if ($conn->connect_error) {
            die("Erreur de connexion à la base de données : " . $conn->connect_error);
        }

        // Utilisation de requêtes préparées pour éviter les injections SQL
        $stmt = $conn->prepare("SELECT id, nom FROM users WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            // L'utilisateur est connecté avec succès
            session_start();
            $_SESSION['login'] = $result->fetch_assoc()['nom'];
            $return = "Vous êtes bien connecté !";
        } else {
            $return = "Nom d'utilisateur ou mot de passe incorrect.";
        }

        // Fermeture de la connexion
        $stmt->close();
        $conn->close();
    } else {
        $return = "Un ou plusieurs champs sont manquants.";
    }
} else {
    $return = "";
}
?>
