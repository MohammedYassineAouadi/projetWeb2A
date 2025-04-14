<?php
require_once __DIR__ . '/../../../config.php';

if (!isset($_GET['idTest'])) {
    die('ID du test manquant.');
}

$id = $_GET['idTest'];
$db = config::getConnexion();

$stmt = $db->prepare("SELECT * FROM tests WHERE idTest = ?");
$stmt->execute([$id]);
$test = $stmt->fetch();

if (!$test) {
    die('Test introuvable.');
}

// Fonction pour nettoyer une réponse (espace + minuscules)
function nettoyer($str) {
    return strtolower(trim($str));
}

// Traitement du formulaire
$score = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $score = 0;

    $rep1 = isset($_POST['reponseT1']) ? nettoyer($_POST['reponseT1']) : '';
    $rep2 = isset($_POST['reponseT2']) ? nettoyer($_POST['reponseT2']) : '';
    $rep3 = isset($_POST['reponseT3']) ? nettoyer($_POST['reponseT3']) : '';

    if ($rep1 === nettoyer($test['reponse_correcteT1'])) {
        $score++;
    }
    if ($rep2 === nettoyer($test['rep_correcteT2'])) {
        $score++;
    }
    if ($rep3 === nettoyer($test['repon_correcteT3'])) {
        $score++;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($test['test_name']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f7f6; font-family: Arial, sans-serif; }
        .test-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-top: 30px;
        }
        h2 { color: #007bff; }
        .question { margin-bottom: 20px; }
        .btn { width: 100%; margin-top: 20px; }
        .alert { text-align: center; font-size: 1.3em; }
    </style>
</head>
<body>
<div class="container">
    <div class="test-container">
        <h2 class="text-center"><?= htmlspecialchars($test['test_name']) ?></h2>

        <?php if ($score !== null): ?>
            <div class="alert alert-success">✅ Votre score : <strong><?= $score ?>/3</strong></div>
        <?php endif; ?>

        <form method="POST">
            <!-- Question 1 -->
            <div class="question">
                <h4><?= htmlspecialchars($test['questionT1']) ?></h4>
                <input type="text" name="reponseT1" class="form-control" required>
            </div>

            <!-- Question 2 -->
            <div class="question">
                <h4><?= htmlspecialchars($test['questionT2']) ?></h4>
                <input type="text" name="reponseT2" class="form-control" required>
            </div>

            <!-- Question 3 -->
            <div class="question">
                <h4><?= htmlspecialchars($test['questionT3']) ?></h4>
                <input type="text" name="reponseT3" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">✅ Valider mes réponses</button>
        </form>

        <div class="mt-3 text-center">
            <a href="Test.php">← Retour aux tests</a>
        </div>
    </div>
</div>
</body>
</html>
