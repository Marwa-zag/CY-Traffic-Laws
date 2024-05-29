<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['user_id']) || !$_SESSION['is_premium']) {
    header("Location: premium.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$date = $_POST['date'] ?? '';

if (empty($date)) {
    die("Date non fournie");
}

echo "User ID: $user_id, Date: $date"; // Débogage des données reçues

$servername = "localhost";
$db_username = "root";
$db_password = "root";
$database = "projet_info";

$conn = new mysqli($servername, $db_username, $db_password, $database);
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . htmlspecialchars($conn->connect_error));
}
echo "Connexion à la base de données réussie.<br>";

// Vérification de la disponibilité de la date
$sql_check = "SELECT COUNT(*) AS count FROM reservations WHERE date = ?";
$stmt_check = $conn->prepare($sql_check);
if (!$stmt_check) {
    die("Préparation de la requête échouée : " . htmlspecialchars($conn->error));
}
$stmt_check->bind_param("s", $date);
$stmt_check->execute();
$result_check = $stmt_check->get_result();
$row_check = $result_check->fetch_assoc();

if ($row_check['count'] == 0) {
    $sql = "INSERT INTO reservations (user_id, date) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Préparation de l'insertion échouée : " . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("is", $user_id, $date);
    if ($stmt->execute()) {
        echo "<script>
            alert('Votre date $date a été réservée. Veuillez venir avec votre pièce d\'identité et une convocation.');
            window.location.href = 'projet.html?message=Réservation effectuée avec succès!';
        </script>";
    } else {
        echo "Erreur lors de l'exécution de l'insertion : " . htmlspecialchars($stmt->error);
    }
    $stmt->close();
} else {
    echo "<script>
        alert('La date sélectionnée est déjà réservée. Veuillez choisir une autre date.');
        window.location.href = 'calendar.html';
    </script>";
}

$stmt_check->close();
$conn->close();
?>
