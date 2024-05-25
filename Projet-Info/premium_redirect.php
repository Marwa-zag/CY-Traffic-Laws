<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$servername = "localhost";
$db_username = "root";
$db_password = "root";
$database = "projet_info";

$conn = new mysqli($servername, $db_username, $db_password, $database);
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . htmlspecialchars($conn->connect_error));
}

$sql = "SELECT is_premium FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($is_premium);
$stmt->fetch();

$stmt->close();
$conn->close();

if ($is_premium) {
    header("Location: plus.html");
} else {
    header("Location: premium.html");
}
exit();
?>
