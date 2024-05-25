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

$result = $conn->query("SELECT id, prenom, username, email, active, role, is_premium FROM users");

if (!$result) {
    die("Erreur lors de la récupération des utilisateurs : " . htmlspecialchars($conn->error));
}

$reservations_result = $conn->query("SELECT r.id, u.prenom, u.username, u.email, r.date FROM reservations r JOIN users u ON r.user_id = u.id");

if (!$reservations_result) {
    die("Erreur lors de la récupération des réservations : " . htmlspecialchars($conn->error));
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les utilisateurs - CY Traffic Laws</title>
    <link rel="stylesheet" href="admin_style.css">
    <script>
        function confirmAction(action, userId) {
            var message = "Êtes-vous sûr de vouloir " + action + " cet utilisateur ?";
            if (confirm(message)) {
                document.getElementById(action + "-form-" + userId).submit();
            }
        }
    </script>
</head>
<body>

<div class="container">
    <header class="header">
        <h1 class="header__title">Gérer les utilisateurs</h1>
        <nav class="nav">
            <ul class="nav__list">
                <li class="nav__item"><a href="admin_home.php" class="nav__link">Retour à l'espace admin</a></li>
            </ul>
        </nav>
    </header>

    <main class="main">
        <h2>Liste des utilisateurs</h2>
        <?php if (isset($_SESSION['message'])): ?>
            <div class="message">
                <?php echo htmlspecialchars($_SESSION['message']); ?>
                <?php unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Prénom</th>
                    <th>Nom d'utilisateur</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Rôle</th>
                    <th>Abonnement</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['prenom']); ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo $user['active'] ? 'Actif' : 'Désactivé'; ?></td>
                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                    <td><?php echo $user['is_premium'] ? 'Premium' : 'Standard'; ?></td>
                    <td>
                        <form id="delete-form-<?php echo $user['id']; ?>" method="post" action="admin_users.php" style="display:inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                            <button type="button" onclick="confirmAction('delete', <?php echo $user['id']; ?>)">Supprimer</button>
                        </form>
                        <?php if ($user['active']): ?>
                            <form id="deactivate-form-<?php echo $user['id']; ?>" method="post" action="admin_users.php" style="display:inline;">
                                <input type="hidden" name="action" value="deactivate">
                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                <button type="button" onclick="confirmAction('deactivate', <?php echo $user['id']; ?>)">Désactiver</button>
                            </form>
                        <?php else: ?>
                            <form id="activate-form-<?php echo $user['id']; ?>" method="post" action="admin_users.php" style="display:inline;">
                                <input type="hidden" name="action" value="activate">
                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                <button type="button" onclick="confirmAction('activate', <?php echo $user['id']; ?>)">Activer</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h2>Liste des réservations</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Prénom</th>
                    <th>Nom d'utilisateur</th>
                    <th>Email</th>
                    <th>Date de réservation</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($reservation = $reservations_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($reservation['id']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['prenom']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['username']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['email']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['date']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

    </main>
</div>

<footer class="footer">
    <div class="container">
        <p class="footer__copyright">Réalisation & design : @Marwa @Mariam @Hafsa.</p>
    </div>
</footer>

</body>
</html>
