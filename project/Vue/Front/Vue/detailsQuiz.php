<?php
require_once __DIR__ . '/../../../config.php';

if (!isset($_GET['idQuiz'])) {
    die('ID du quiz manquant.');
}

$idQuiz = $_GET['idQuiz'];
$db = config::getConnexion();

// Récupérer les détails du quiz depuis la base de données
$stmt = $db->prepare("SELECT * FROM quizzes WHERE idQuiz = ?");
$stmt->execute([$idQuiz]);
$quiz = $stmt->fetch();

if (!$quiz) {
    die('Quiz introuvable.');
}

// Calcul du score
$score = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $score = 0;

    // Récupérer les réponses de l'utilisateur
    $reponseQ1 = isset($_POST['q1']) ? $_POST['q1'] : '';
    $reponseQ2 = isset($_POST['q2']) ? $_POST['q2'] : '';
    $reponseQ3 = isset($_POST['q3']) ? $_POST['q3'] : '';

    // Comparer les réponses avec les bonnes réponses
    if ($reponseQ1 === (isset($quiz['correct_option1']) ? $quiz['correct_option1'] : '')) $score++;
    if ($reponseQ2 === (isset($quiz['correct_op2']) ? $quiz['correct_op2'] : '')) $score++;
    if ($reponseQ3 === (isset($quiz['correct_opt3']) ? $quiz['correct_opt3'] : '')) $score++;

    // Récupérer l'ID de l'utilisateur (par exemple, stocké dans la session ou via un champ caché)
    $idUser = 1;  // Remplace par l'ID réel de l'utilisateur
    // Mettre à jour le score dans la base de données
    $stmt = $db->prepare("UPDATE score SET resultatQuiz = ? WHERE idUser = ? AND idQuiz = ?");
    $stmt->execute([$score, $idUser, $idQuiz]);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Test - Détails</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>

<body>
    <!-- Affichage du score -->
    <?php if ($score !== null): ?>
        <div class="alert alert-success">
            ✅ Votre score : <strong><?= $score ?>/3</strong>
        </div>
    <?php endif; ?>

    <!-- Formulaire pour répondre aux questions -->
    <form method="POST">
        <p>Question 1 : <?= htmlspecialchars($quiz['questionQ1'] ?? 'Question 1') ?></p>
        <input type="radio" name="q1" value="<?= htmlspecialchars($quiz['option1'] ?? '') ?>" /> <?= htmlspecialchars($quiz['option1'] ?? 'Option 1') ?><br>
        <input type="radio" name="q1" value="<?= htmlspecialchars($quiz['option2'] ?? '') ?>" /> <?= htmlspecialchars($quiz['option2'] ?? 'Option 2') ?><br>
        <input type="radio" name="q1" value="<?= htmlspecialchars($quiz['option3'] ?? '') ?>" /> <?= htmlspecialchars($quiz['option3'] ?? 'Option 3') ?><br>

        <p>Question 2 : <?= htmlspecialchars($quiz['questionQ2'] ?? 'Question 2') ?></p>
        <input type="radio" name="q2" value="<?= htmlspecialchars($quiz['op1'] ?? '') ?>" /> <?= htmlspecialchars($quiz['op1'] ?? 'Option 1') ?><br>
        <input type="radio" name="q2" value="<?= htmlspecialchars($quiz['op2'] ?? '') ?>" /> <?= htmlspecialchars($quiz['op2'] ?? 'Option 2') ?><br>
        <input type="radio" name="q2" value="<?= htmlspecialchars($quiz['op3'] ?? '') ?>" /> <?= htmlspecialchars($quiz['op3'] ?? 'Option 3') ?><br>

        <p>Question 3 : <?= htmlspecialchars($quiz['questionQ3'] ?? 'Question 3') ?></p>
        <input type="radio" name="q3" value="<?= htmlspecialchars($quiz['opt1'] ?? '') ?>" /> <?= htmlspecialchars($quiz['opt1'] ?? 'Option 1') ?><br>
        <input type="radio" name="q3" value="<?= htmlspecialchars($quiz['opt2'] ?? '') ?>" /> <?= htmlspecialchars($quiz['opt2'] ?? 'Option 2') ?><br>
        <input type="radio" name="q3" value="<?= htmlspecialchars($quiz['opt3'] ?? '') ?>" /> <?= htmlspecialchars($quiz['opt3'] ?? 'Option 3') ?><br>

        <input type="hidden" name="iduser" value="1"> <!-- ID utilisateur (ajuste cela avec la variable de session ou d'autres méthodes) -->

        <button type="submit" class="btn btn-primary">Soumettre</button>
    </form>

    <script src="../assets/js/jquery-2.1.0.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
</body>

</html>
