<?php
require_once __DIR__ . '/../../../config.php';
require_once __DIR__ . '/../../../Controller/ajouterQuiz.php';

if (!isset($_GET['idQuiz'])) {
    die('ID du quiz manquant.');
}

$id = $_GET['idQuiz'];
$db = config::getConnexion();

$stmt = $db->prepare("SELECT * FROM quizzes WHERE idQuiz = ?");
$stmt->execute([$id]);
$quiz = $stmt->fetch();

if (!$quiz) {
    die('Quiz introuvable.');
}

// Si le formulaire est soumis, traiter la réponse
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les réponses
    $reponseQ1 = $_POST['reponseQ1'];
    $reponseQ2 = $_POST['reponseQ2'];
    $reponseQ3 = $_POST['reponseQ3'];

    // Vérifier les réponses (ajuster selon la logique de ton quiz)
    $score = 0;
    if ($reponseQ1 == $quiz['correct_option1']) {
        $score++;
    }
    if ($reponseQ2 == $quiz['correct_op2']) {
        $score++;
    }
    if ($reponseQ3 == $quiz['correct_opt3']) {
        $score++;
    }

    echo "<h3 class='alert alert-success'>Votre score: $score/3</h3>";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($quiz['quiz_name']) ?></title>
    <!-- Intégration de Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Ajout de notre propre CSS -->
    <style>
        body {
            background-color: #f4f7f6;
            font-family: Arial, sans-serif;
        }
        .quiz-container {
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            border-radius: 8px;
            margin-top: 30px;
        }
        h2 {
            color: #007bff;
        }
        h4 {
            margin-top: 20px;
            font-size: 1.2em;
            color: #333;
        }
        .question {
            margin-bottom: 20px;
        }
        .btn {
            width: 100%;
            margin-bottom: 10px;
        }
        .alert {
            text-align: center;
            font-size: 1.5em;
        }
        .back-link {
            margin-top: 20px;
            display: block;
            text-align: center;
            font-size: 1.1em;
        }
        .back-link a {
            text-decoration: none;
            color: #007bff;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="quiz-container">
        <h2 class="text-center"><?= htmlspecialchars($quiz['quiz_name']) ?></h2>

        <form method="POST">
            <!-- Question 1 -->
            <div class="question">
                <h4><?= $quiz['questionQ1'] ?></h4>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="reponseQ1" value="1" id="option1" required>
                    <label class="form-check-label" for="option1"><?= $quiz['option1'] ?></label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="reponseQ1" value="2" id="option2" required>
                    <label class="form-check-label" for="option2"><?= $quiz['option2'] ?></label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="reponseQ1" value="3" id="option3" required>
                    <label class="form-check-label" for="option3"><?= $quiz['option3'] ?></label>
                </div>
            </div>

            <!-- Question 2 -->
            <div class="question">
                <h4><?= $quiz['questionQ2'] ?></h4>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="reponseQ2" value="1" id="op1" required>
                    <label class="form-check-label" for="op1"><?= $quiz['op1'] ?></label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="reponseQ2" value="2" id="op2" required>
                    <label class="form-check-label" for="op2"><?= $quiz['op2'] ?></label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="reponseQ2" value="3" id="op3" required>
                    <label class="form-check-label" for="op3"><?= $quiz['op3'] ?></label>
                </div>
            </div>

            <!-- Question 3 -->
            <div class="question">
                <h4><?= $quiz['questionQ3'] ?></h4>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="reponseQ3" value="1" id="opt1" required>
                    <label class="form-check-label" for="opt1"><?= $quiz['opt1'] ?></label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="reponseQ3" value="2" id="opt2" required>
                    <label class="form-check-label" for="opt2"><?= $quiz['opt2'] ?></label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="reponseQ3" value="3" id="opt3" required>
                    <label class="form-check-label" for="opt3"><?= $quiz['opt3'] ?></label>
                </div>
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn btn-primary">Valider le quiz</button>
        </form>

        <div class="back-link">
            <a href="Quiz.php">← Retour à la liste des quiz</a>
        </div>
    </div>
</div>

<!-- Scripts Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
