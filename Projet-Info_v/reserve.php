<?php
session_start();
if (!isset($_SESSION['user_id']) || !$_SESSION['is_premium']) {
    header("Location: premium.html"); // Redirection vers la page premium si l'utilisateur n'est pas connecté ou n'est pas premium
    exit();
}

$user_id = $_SESSION['user_id'];
$date = $_POST['date']; // Récupération de la date depuis le formulaire
$servername = "localhost";
$db_username = "root";
$db_password = "root";
$database = "projet_info";

$conn = new mysqli($servername, $db_username, $db_password, $database);
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . htmlspecialchars($conn->connect_error));
}

// Vérification de la disponibilité de la date
$sql_check = "SELECT COUNT(*) AS count FROM reservations WHERE date = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("s", $date);
$stmt_check->execute();
$result_check = $stmt_check->get_result();
$row_check = $result_check->fetch_assoc();

if ($row_check['count'] == 0) {
    // Si la date est disponible, insertion de la réservation dans la base de données
    $sql = "INSERT INTO reservations (user_id, date) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $user_id, $date);
    if ($stmt->execute()) {
        // Redirection vers la page principale avec un message de succès
        header("Location: projet.html?message=Réservation effectuée avec succès!");
    } else {
        echo "Erreur : " . $stmt->error;
    }
    $stmt->close();
} else {
    // Affichage d'une alerte si la date est déjà réservée
    echo "<script>
        alert('La date sélectionnée est déjà réservée. Veuillez choisir une autre date.');
        window.location.href = 'calendar.html';
    </script>";
}

$stmt_check->close();
$conn->close();
?>
