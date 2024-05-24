<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    header("Location: connexion.php");
    exit();
}

// Gérer la déconnexion
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: connexion.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'accueil</title>
    <link rel="stylesheet" href="style.css"> <!-- Lien vers le fichier CSS pour le style -->
</head>
<body>
<div class="container">
    <header class="header">
        <h1 class="header__title">CY Traffic Laws</h1>
        <p class="header__slogan">Conduisez en toute confiance</p>

        <div class="menu-icon" onclick="toggleMenu()">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>

        <div class="login-icon">
            <a href="accueil.php?logout=true"><img src="logout-icon.png" alt="Icône de déconnexion"></a>
        </div>

        <nav class="nav" id="nav-menu">
            <ul class="nav__list">
                <li class="nav__item"><a href="accueil.php" class="nav__link">Accueil</a></li>
                <li class="nav__item"><a href="lessons.html" class="nav__link">Leçons</a></li>
                <li class="nav__item"><a href="exercise.html" class="nav__link">Entraînement</a></li>
                <li class="nav__item"><a href="exams.html" class="nav__link">Examens</a></li>
                <li class="nav__item"><a href="tutoriel.html" class="nav__link">Tutoriel</a></li>
                <li class="nav__item"><a href="about.html" class="nav__link">À propos</a></li>
                <li class="nav__item"><a href="contact.html" class="nav__link">Contact</a></li>
            </ul>
        </nav>
    </header>

    <main class="main">
        <!-- Présentation de votre site -->
        <section class="presentation">
            <h2 class="presentation__title">Bienvenue sur CY Traffic Laws, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
            <p class="presentation__text">Nous sommes là pour vous aider à réussir votre code de la route. Découvrez nos leçons, nos examens pratiques et d'autres ressources pour vous accompagner dans votre apprentissage.</p>
        </section>

        <!-- Image -->
        <section class="image">
            <img src="route.jpg" alt="Image du code de la route">
        </section>
    </main>
</div>

<footer class="footer">
    <div class="container">
        <p class="footer__copyright">Réalisation & design : @Marwa @Mariam @Hafsa @Bayane</p>
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
