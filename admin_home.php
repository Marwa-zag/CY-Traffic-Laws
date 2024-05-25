<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: projet.html");
    exit();
}

include('config.php');

// Récupérer les 10 dernières connexions des utilisateurs
$query_last_logins = "SELECT nom, prenom, email, last_login FROM users ORDER BY last_login DESC LIMIT 10";
$result_last_logins = mysqli_query($conn, $query_last_logins);

if (!$result_last_logins) {
    die("Erreur lors de l'exécution de la requête: " . mysqli_error($conn));
}

// Récupérer les 10 derniers messages du forum
$query_last_messages = "SELECT forum_posts.content, forum_posts.created_at, users.nom, users.prenom 
                        FROM forum_posts 
                        JOIN users ON forum_posts.user_id = users.id 
                        ORDER BY forum_posts.created_at DESC LIMIT 10";
$result_last_messages = mysqli_query($conn, $query_last_messages);

if (!$result_last_messages) {
    die("Erreur lors de l'exécution de la requête: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - CY Traffic Laws</title>
    <link rel="stylesheet" href="admin_style.css"> 
</head>
<body>

<div id="welcome-message">
    <?php
    if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {
        echo "<p>Bonjour Admin, ça fait longtemps! Ravi de vous revoir.</p>";
    }
    ?>
</div>

<div class="container">
    <header class="header">
        <h1 class="header__title">Espace Administration</h1>

        <div class="menu-icon" onclick="toggleMenu()">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>

        <div class="login-icon">
            <a href="logout.php"><img src="icone_deco.png" alt="Icône de déconnexion"></a>
        </div>
        
        <nav class="nav" id="nav-menu">
            <ul class="nav__list">
                <li class="nav__item"><a href="manage_users.php" class="nav__link">Gérer les utilisateurs</a></li>
                <li class="nav__item"><a href="manage_exercises.php" class="nav__link">Gérer les exercices</a></li>
                <li class="nav__item"><a href="manage_forum.php" class="nav__link">Gérer le forum</a></li>
                <!-- Ajouter d'autres liens pour les fonctionnalités d'administration ici -->
            </ul>
        </nav>
    </header>
</div>

<div class="content">
    <section class="last-logins">
        <h2>Dernières connexions des utilisateurs</h2>
        <table>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Dernière connexion</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result_last_logins)) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['nom']); ?></td>
                    <td><?php echo htmlspecialchars($row['prenom']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['last_login']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </section>

    <section class="last-messages">
        <h2>Derniers messages du forum</h2>
        <table>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Date</th>
                <th>Message</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result_last_messages)) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['nom']); ?></td>
                    <td><?php echo htmlspecialchars($row['prenom']); ?></td>
                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                    <td><?php echo htmlspecialchars($row['content']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </section>
</div>

<footer class="footer">
    <div class="container">
        <p class="footer__copyright"> Réalisation & design : @Marwa @Mariam @Hafsa.</p>
    </div>
</footer>

<script>
    function toggleMenu() {
        var navMenu = document.getElementById("nav-menu");
        navMenu.classList.toggle("active");
    }
</script>

</body>
</html>
