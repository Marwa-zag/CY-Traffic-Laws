<?php
session_start();

// Vérifier si l'utilisateur est administrateur
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: login.html");
    exit();
}

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "root";
$database = "projet_info";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . htmlspecialchars($conn->connect_error));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    $post_id = intval($_POST['post_id']);

    switch ($action) {
        case 'delete':
            $query = "DELETE FROM forum_posts WHERE id = $post_id";
            break;
        default:
            // Gérer le cas de bloquer un message d'un utilisateur (le faire quand on a le temps )
            break;
    }

    if ($conn->query($query) === TRUE) {
        $_SESSION['message'] = "Action réalisée avec succès.";
    } else {
        $_SESSION['message'] = "Erreur lors de l'exécution de l'action : " . htmlspecialchars($conn->error);
    }

    $conn->close();
    header("Location: manage_forum.php");
    exit();
}

$result = $conn->query("SELECT id, user_id, content, created_at FROM forum_posts ORDER BY created_at DESC");

if (!$result) {
    die("Erreur lors de la récupération des messages du forum : " . htmlspecialchars($conn->error));
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum - CY Traffic Laws</title>
    <link rel="stylesheet" href="admin_style.css"> 
</head>
<nav>
    <ul>
        <a href="admin_home.php"><img src="Image/fleche.png" alt="Retour" width="20" height="20"></a>
    </ul>
 </nav>
<body>

<div class="container">

    <main class="main">
        <h2>Liste des messages du forum</h2>
        <?php if (isset($_SESSION['message'])): ?>
            <div class="message">
                <?php echo htmlspecialchars($_SESSION['message']); ?>
                <?php unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Utilisateur</th>
                    <th>Message</th>
                    <th>Date de création</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($post = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($post['id']); ?></td>
                    <td><?php echo htmlspecialchars($post['user_id']); ?></td>
                    <td><?php echo htmlspecialchars($post['content']); ?></td>
                    <td><?php echo htmlspecialchars($post['created_at']); ?></td>
                    <td>
                        <form id="delete-form-<?php echo $post['id']; ?>" method="post" action="manage_forum.php" style="display:inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                            <button type="button" onclick="confirmAction('delete', <?php echo $post['id']; ?>)">Supprimer</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>
</div>

<script>
    function confirmAction(action, postId) {
        var message = "Êtes-vous sûr de vouloir " + action + " ce message ?";
        if (confirm(message)) {
            document.getElementById(action + "-form-" + postId).submit();
        }
    }
</script>

</body>
</html>
