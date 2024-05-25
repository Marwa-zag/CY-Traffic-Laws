<?php
session_start();

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: login.html");
    exit();
}

$files = [
    'entrainement_questions.json',
    'entrainement2_questions.json',
    'entrainement3_questions.json',
    'examen_questions.json',
    'exercice_sup1_questions.json',
    'exercice_sup2_questions.json',
    'exercice_sup3_questions.json',
    'examen_sup1_questions.json',
    'examen_sup2_questions.json'
];

$selectedFile = isset($_POST['file']) ? $_POST['file'] : $files[0];

function readQuestionsFromFile($filename) {
    $json = file_get_contents($filename);
    return json_decode($json, true);
}

function writeQuestionsToFile($filename, $questions) {
    $json = json_encode($questions, JSON_PRETTY_PRINT);
    file_put_contents($filename, $json);
}

function addQuestion($filename, $newQuestion) {
    $questions = readQuestionsFromFile($filename);
    $questions[] = $newQuestion;
    writeQuestionsToFile($filename, $questions);
}

function deleteQuestion($filename, $questionIndex) {
    $questions = readQuestionsFromFile($filename);
    if (isset($questions[$questionIndex])) {
        array_splice($questions, $questionIndex, 1);
        writeQuestionsToFile($filename, $questions);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'add') {
            $newQuestion = [
                'question' => $_POST['question'],
                'imageSrc' => $_POST['imageSrc'],
                'options' => [
                    $_POST['option1'],
                    $_POST['option2'],
                    $_POST['option3']
                ],
                'answer' => $_POST['answer'],
                'timeLimit' => intval($_POST['timeLimit'])
            ];
            addQuestion($selectedFile, $newQuestion);
        } elseif ($_POST['action'] === 'delete') {
            $questionIndex = intval($_POST['questionIndex']);
            deleteQuestion($selectedFile, $questionIndex);
        }
        // Rafraîchir la page pour refléter les modifications
        header("Location: manage_exercises.php?file=" . urlencode($selectedFile));
        exit();
    }
}

$questions = readQuestionsFromFile($selectedFile);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les exercices - CY Traffic Laws</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>

<div class="container">
    <header class="header">
        <h1>Gérer les exercices</h1>
        <nav>
            <ul>
                <a href="admin_home.php"><img src="fleche.png" alt="Retour" width="20" height="20"></a>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Sélectionner le fichier JSON</h2>
        <form method="POST" id="fileForm">
            <label for="file">Fichier JSON :</label>
            <select name="file" id="file" onchange="document.getElementById('fileForm').submit()">
                <?php foreach ($files as $file): ?>
                <option value="<?php echo $file; ?>" <?php echo $file === $selectedFile ? 'selected' : ''; ?>>
                    <?php echo $file; ?>
                </option>
                <?php endforeach; ?>
            </select>
        </form>

        <h2>Ajouter un exercice</h2>
        <form method="POST">
            <input type="hidden" name="file" value="<?php echo $selectedFile; ?>">
            <input type="hidden" name="action" value="add">
            <label for="question">Question :</label>
            <input type="text" name="question" required>
            <label for="imageSrc">Image URL :</label>
            <input type="text" name="imageSrc" required>
            <label for="option1">Option 1 :</label>
            <input type="text" name="option1" required>
            <label for="option2">Option 2 :</label>
            <input type="text" name="option2" required>
            <label for="option3">Option 3 :</label>
            <input type="text" name="option3" required>
            <label for="answer">Réponse :</label>
            <input type="text" name="answer" required>
            <label for="timeLimit">Limite de temps :</label>
            <input type="number" name="timeLimit" required>
            <button type="submit">Ajouter</button>
        </form>

        <h2>Liste des exercices</h2>
        <table>
            <thead>
                <tr>
                    <th>Question</th>
                    <th>Image</th>
                    <th>Options</th>
                    <th>Réponse</th>
                    <th>Limite de temps</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($questions as $index => $question): ?>
                <tr>
                    <td><?php echo htmlspecialchars($question['question']); ?></td>
                    <td><img src="<?php echo htmlspecialchars($question['imageSrc']); ?>" alt="Image de la question" width="100"></td>
                    <td>
                        <?php foreach ($question['options'] as $option): ?>
                            <p><?php echo htmlspecialchars($option); ?></p>
                        <?php endforeach; ?>
                    </td>
                    <td><?php echo htmlspecialchars($question['answer']); ?></td>
                    <td><?php echo htmlspecialchars($question['timeLimit']); ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="file" value="<?php echo $selectedFile; ?>">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="questionIndex" value="<?php echo $index; ?>">
                            <button type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</div>

<footer>
    <p>Réalisation & design : @Marwa @Mariam @Hafsa.</p>
</footer>

</body>
</html>
