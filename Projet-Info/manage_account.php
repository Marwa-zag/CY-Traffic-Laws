<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "root";
$database = "projet_info";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . htmlspecialchars($conn->connect_error));
}

$user_id = $_SESSION['user_id'];

$result = $conn->query("SELECT id, prenom, username, email, active, role, profile_pic FROM users WHERE id = $user_id");
$user = $result->fetch_assoc();

$conn->close();

if ($user['active'] == 0) {
    $_SESSION['message'] = "Votre compte est désactivé. Souhaitez-vous le réactiver ?";
    header("Location: reactivate_account.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer mon compte - CY Traffic Laws</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>

<div class="container">
    <header class="header">
        <h1 class="header__title">Gérer mon compte</h1>
        <nav class="nav">
            <ul class="nav__list">
                <li class="nav__item"><a href="projet.html" class="nav__link">Retour à l'accueil</a></li>
            </ul>
        </nav>
    </header>

    <main class="main">
        <h2>Mon compte</h2>
        <?php if (isset($_SESSION['message'])): ?>
            <div class="message">
                <?php echo htmlspecialchars($_SESSION['message']); ?>
                <?php unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>

        <form method="post" action="user_actions.php" enctype="multipart/form-data">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Prénom</th>
                        <th>Nom d'utilisateur</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Photo de profil</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                        <td><input type="text" name="prenom" value="<?php echo htmlspecialchars($user['prenom']); ?>"></td>
                        <td><input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>"></td>
                        <td><input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"></td>
                        <td><?php echo $user['active'] ? 'Actif' : 'Désactivé'; ?></td>
                        <td>
                            <div id="profile-pic-container">
                                <?php if ($user['profile_pic']): ?>
                                    <img src="uploads/<?php echo htmlspecialchars($user['profile_pic']); ?>" alt="Photo de profil" style="border-radius: 50%; width: 75px; height: 75px;">
                                <?php else: ?>
                                    <img src="uploads/default.png" alt="Photo de profil" style="border-radius: 50%; width: 75px; height: 75px;">
                                <?php endif; ?>
                                <input type="file" id="profile-pic-input" name="profile_pic" style="display: none;">
                            </div>
                        </td>
                        <td>
                            <input type="hidden" name="action" value="update">
                            <button type="submit">Mettre à jour</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>

        <h2>Changer le mot de passe</h2>
        <form method="post" action="user_actions.php">
            <input type="hidden" name="action" value="change_password">
            <div>
                <label for="current_password">Mot de passe actuel:</label>
                <input type="password" name="current_password" id="current_password" required>
            </div>
            <div>
                <label for="new_password">Nouveau mot de passe:</label>
                <input type="password" name="new_password" id="new_password" required>
            </div>
            <div>
                <label for="confirm_password">Confirmer le nouveau mot de passe:</label>
                <input type="password" name="confirm_password" id="confirm_password" required>
            </div>
            <button type="submit">Changer le mot de passe</button>
        </form>

        <h2>Actions supplémentaires</h2>
        <form method="post" action="user_actions.php">
            <input type="hidden" name="action" value="deactivate">
            <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir désactiver votre compte ?');">Désactiver mon compte</button>
        </form>
        <form method="post" action="user_actions.php">
            <input type="hidden" name="action" value="cancel_subscription">
            <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir résilier votre abonnement ?');">Résilier mon abonnement</button>
        </form>
    </main>
</div>

<footer class="footer">
    <div class="container">
        <p class="footer__copyright">Réalisation & design : @Marwa @Mariam @Hafsa.</p>
    </div>
</footer>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const profilePicInput = document.getElementById('profile-pic-input');
        const profilePicContainer = document.getElementById('profile-pic-container');

        profilePicContainer.addEventListener('click', function() {
            profilePicInput.click();
        });
    });
</script>

</body>
</html>
