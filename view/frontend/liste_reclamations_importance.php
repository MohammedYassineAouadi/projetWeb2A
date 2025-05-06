<?php
require_once '../../controllers/ReclamationController.php';
require_once 'detecter_mots_cles.php'; // Fonction qui retourne un tableau de mots-clés détectés

$controller = new ReclamationController();
$reclamations = $controller->read(); // Appel à la bonne méthode du contrôleur

// Ajouter l'importance à chaque réclamation
foreach ($reclamations as &$rec) {
    $mots = detecter_mots_cles($rec['contenu']);
    $rec['importance'] = count($mots);
}

// Trier les réclamations par importance décroissante
usort($reclamations, function($a, $b) {
    return $b['importance'] - $a['importance'];
});
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réclamations par Importance</title>
    <link rel="stylesheet" href="../frontend/style2.css">
    <style>
    .low {
        background-color: #a8d5a2;
        color: #0b3d0b;
    }
    .medium {
        background-color: #ffc107;
        color: #4a2c00;
    }
    .high {
        background-color: #dc3545;
        color: #fff;
    }

    .channel-table th, .channel-table td {
        padding: 10px;
        border: 1px solid #ccc;
    }

    .channel-table thead th {
        color: #000; /* Texte noir */
        background-color: #e2e2e2; /* Fond gris clair */
        font-weight: bold;
    }
</style>


</head>
<body>

<header>
    <h1>📊 Réclamations Triées par Importance</h1>
</header>

<main class="container">

    <table class="channel-table">
        <thead>
            <tr>
                <th>ID Réclamation</th>
                <th>Contenu</th>
                <th>Importance</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($reclamations as $rec): ?>
            <?php
                $importance = $rec['importance'];
                $rowClass = $importance >= 3 ? 'high' : ($importance == 2 ? 'medium' : 'low');
            ?>
            <tr class="<?= $rowClass ?>">
                <td><?= htmlspecialchars($rec['idreclamation']) ?></td>
                <td><?= htmlspecialchars($rec['contenu']) ?></td>
                <td><?= $importance ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        <a href="../frontend/reponse.php">
            <button style="padding: 10px 20px;">⬅️ Retour à l'interface Réponse</button>
        </a>
    </div>
    <div style="margin-top: 20px; display: flex; gap: 10px;">
    <a href="../frontend/reponse.php">
        <button style="padding: 10px 20px;">⬅️ Retour à l'interface Réponse</button>
    </a>
    <a href="../../view/backend/escalader_reclamations.php">
        <button style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 4px;">
            🚨 Lancer l’escalade automatique
        </button>
    </a>
</div>
<div style="margin-top: 20px; display: flex; gap: 10px;">
        <a href="../frontend/reponse.php">
            <button style="padding: 10px 20px;">⬅️ Retour à l'interface Réponse</button>
        </a>
        <a href="../../view/backend/escalader_reclamations.php">
            <button style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 4px;">
                🚨 Lancer l’escalade automatique
            </button>
        </a>
        <a href="dashboard.php">
            <button style="padding: 10px 20px; background-color: #28a745; color: white; border: none; border-radius: 4px;">
                📈 Voir le Dashboard
            </button>
        </a>
    </div>



</main>

</body>
</html>
