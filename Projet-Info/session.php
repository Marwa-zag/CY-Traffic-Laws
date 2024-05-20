<?php
session_start();
header('Content-Type: application/json');

$response = [
    'prenom' => isset($_SESSION['prenom']) ? htmlspecialchars($_SESSION['prenom']) : null,
    'is_admin' => isset($_SESSION['is_admin']) ? $_SESSION['is_admin'] : false
];

echo json_encode($response);
?>

