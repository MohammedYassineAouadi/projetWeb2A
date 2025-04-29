<?php
require_once '../../controllers/ReponseController.php';

$controller = new ReponseController();

// Vérifie si l'ID de la réclamation est fourni
if (isset($_GET['idreclamation'])) {
    $idReclamation = $_GET['idreclamation'];

    // Récupère la réponse associée à cette réclamation
    $reponse = $controller->getReponseByReclamationId($idReclamation);
} else {
    $reponse = null;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Voir la Réponse</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Réponse à la Réclamation</h1>
</header>

<main class="container">
    <?php if ($reponse): ?>
        <div class="announcement-card">
            <p><strong>ID Réclamation :</strong> <?= htmlspecialchars($reponse['idreclamation']) ?></p>
            <p><strong>Message :</strong> <?= htmlspecialchars($reponse['message']) ?></p>
            <p><strong>Date :</strong> <?= htmlspecialchars($reponse['daterep']) ?></p>
            <p><strong>Type :</strong> <?= htmlspecialchars($reponse['typerep']) ?></p>
        </div>
    <?php else: ?>
        <p style="color: red;">❌ Aucune réponse trouvée pour cette réclamation.</p>
    <?php endif; ?>

    <a href="index.php" style="display: inline-block; margin-top: 20px;">⬅️ Retour aux réclamations</a>
</main>

<footer>
    &copy; 2025 Startup Academy. Tous droits réservés.
</footer>

</body>
</html>
