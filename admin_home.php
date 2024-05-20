<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - CY Traffic Laws</title>
    <link rel="stylesheet" href="admin_style.css"> 
</head>
<body>

<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: projet.html");
    exit();
}
?>

<div id="welcome-message">
    <?php
    if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {
        echo "<p>Bonjour Admin, ça fait longtemps! Ravi de vous revoir.</p>";
        echo "<p>Dernière connexion : " . (isset($_SESSION['last_login']) ? $_SESSION['last_login'] : '') . "</p>";
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
