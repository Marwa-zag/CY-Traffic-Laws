<?php
session_start();

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
$reservation_id = $_POST['reservation_id'];
$new_date = $_POST['new_date'];

// Vérifiez si la nouvelle date est passée
$current_date = date('Y-m-d');
if ($new_date < $current_date) {
    $_SESSION['message'] = "Vous ne pouvez pas choisir une date passée.";
    header("Location: manage_account.php");
    exit();
}

// Vérifiez si la nouvelle date est déjà réservée
$sql_check = "SELECT COUNT(*) AS count FROM reservations WHERE date = ?";
$stmt_check = $conn->prepare($sql_check);
if (!$stmt_check) {
    die("Erreur de préparation de la requête : " . htmlspecialchars($conn->error));
}
$stmt_check->bind_param("s", $new_date);
$stmt_check->execute();
$result_check = $stmt_check->get_result();
$row_check = $result_check->fetch_assoc();

if ($row_check['count'] > 0) {
    $_SESSION['message'] = "La nouvelle date est déjà réservée.";
    header("Location: manage_account.php");
    exit();
}

$sql = "UPDATE reservations SET date = ? WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Erreur de préparation de la requête : " . htmlspecialchars($conn->error));
}
$stmt->bind_param("sii", $new_date, $reservation_id, $user_id);
if ($stmt->execute()) {
    $_SESSION['message'] = "Réservation modifiée avec succès.";
} else {
    $_SESSION['message'] = "Erreur lors de la modification de la réservation.";
}

$stmt->close();
$conn->close();

header("Location: manage_account.php");
exit();
?>
