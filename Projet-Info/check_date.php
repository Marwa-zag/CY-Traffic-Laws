<?php
$servername = "localhost";
$db_username = "root";
$db_password = "root";
$database = "projet_info";

$date = $_GET['date'];

$conn = new mysqli($servername, $db_username, $db_password, $database);
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . htmlspecialchars($conn->connect_error));
}

$sql = "SELECT COUNT(*) AS count FROM reservations WHERE date = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $date);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$response = array("available" => $row['count'] == 0);

echo json_encode($response);

$stmt->close();
$conn->close();
?>
