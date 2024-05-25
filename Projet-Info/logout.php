<?php
session_start();
session_unset(); // Supprimer toutes les variables de session
session_destroy();
header("Location: login.html");
exit();
?>
