<?php
// Connexion à la base de données
$conn = new mysqli('localhost', 'root', 'root', 'projet_info');

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database connection error']);
    exit();
}

$sql = "SELECT users.prenom AS user, forum_posts.content, forum_posts.created_at 
        FROM forum_posts 
        INNER JOIN users ON forum_posts.user_id = users.id 
        ORDER BY forum_posts.created_at DESC";

$result = $conn->query($sql);

$forumPosts = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $forumPosts[] = $row;
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode(['forumPosts' => $forumPosts]);
?>
