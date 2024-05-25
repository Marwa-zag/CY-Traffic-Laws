<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html"); // Redirection vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}

$user_id = $_SESSION['user_id'];
$servername = "localhost";
$db_username = "root";
$db_password = "root";
$database = "projet_info";

$conn = new mysqli($servername, $db_username, $db_password, $database);
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . htmlspecialchars($conn->connect_error));
}

// Vérifier si l'utilisateur est déjà abonné
$sql = "SELECT is_premium FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($is_premium);
$stmt->fetch();
$stmt->close();

if ($is_premium) {
    // Si déjà abonné, rediriger vers la page plus.html
    $_SESSION['is_premium'] = true;
    header("Location: plus.html");
} else {
    // Mettre à jour l'abonnement de l'utilisateur
    $sql = "UPDATE users SET is_premium = TRUE WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute()) {
        $_SESSION['is_premium'] = true;
        echo "<script>
            alert('Félicitations, vous êtes maintenant membre premium!'); // Affiche un message de félicitations
            window.location.href = 'plus.html'; // Redirige vers la page premium
        </script>";
    } else {
        echo "Erreur : " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
