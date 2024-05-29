<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirige vers la page de connexion si non authentifié
    exit();
}
?>


