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

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['reactivate'])) {
        $stmt = $conn->prepare("UPDATE users SET active = 1 WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();

        $_SESSION['message'] = "Votre compte a été réactivé avec succès.";
        // Redirection vers manage_account.php sans détruire la session
        header("Location: manage_account.php");
        exit();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réactivation du compte - CY Traffic Laws</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>

<div class="container">
    <header class="header">
        <h1 class="header__title">Réactivation du compte</h1>
    </header>

    <main class="main">
        <h2>Réactiver votre compte</h2>
        <p>Votre compte est désactivé. Souhaitez-vous le réactiver ?</p>
        <form method="post" action="reactivate_account.php">
            <button type="submit" name="reactivate">Réactiver</button>
        </form>
    </main>
</div>

<footer class="footer">
    <div class="container">
        <p class="footer__copyright">Réalisation & design : @Marwa @Mariam @Hafsa.</p>
    </div>
</footer>

</body>
</html>