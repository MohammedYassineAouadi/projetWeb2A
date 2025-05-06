<?php
require_once 'config.php';
require_once '../../controllers/ReclamationController.php';

$model = new ReclamationModel($pdo);
$reclamations = $model->getAllReclamations();

$now = new DateTime();
$escaladees = [];

foreach ($reclamations as $rec) {
    $dateCreation = new DateTime($rec['datereclamation']);
    $interval = $now->diff($dateCreation);

    if ($interval->days >= 2 && $rec['statut'] !== 'résolu') {
        // Escalader la réclamation
        $model->escaladerReclamation($rec['idreclamation']);
        $escaladees[] = $rec;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultat de l’Escalade</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        h2 {
            color: #2c3e50;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            background-color: #fff;
            border-left: 5px solid #e74c3c;
            margin-bottom: 10px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .info {
            font-size: 14px;
            color: #555;
        }

        .success {
            color: green;
        }

        .none {
            color: #999;
        }

        a.button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        a.button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

<?php if (count($escaladees) > 0): ?>
    <h2 class="success">✅ <?= count($escaladees) ?> réclamation(s) escaladée(s)</h2>
    <ul>
        <?php foreach ($escaladees as $rec): ?>
            <li>
                <strong>ID:</strong> <?= htmlspecialchars($rec['idreclamation']) ?><br>
                <strong>Date:</strong> <?= htmlspecialchars($rec['datereclamation']) ?><br>
                <strong>Contenu:</strong> <span class="info"><?= htmlspecialchars($rec['contenu']) ?></span>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <h2 class="none">ℹ️ Aucune réclamation à escalader</h2>
<?php endif; ?>

<a class="button" href="../frontend/liste_reclamations_importance.php">⬅️ Retour à la liste</a>

</body>
</html>
