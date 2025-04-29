<?php
require_once '../../controllers/ReponseController.php';

$controller = new ReponseController();

// Lire toutes les réponses
$reponses = $controller->getAllReponses();

// Vérifier si on édite une réponse
$editData = null;
if (isset($_GET['edit'])) {
    $editData = $controller->getReponseById($_GET['edit']);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Réponses</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Gestion des Réponses</h1>
</header>

<main class="container">

    <?php if (isset($_GET['success'])): ?>
        <p style="color: green;">✅ Réponse ajoutée avec succès !</p>
    <?php elseif (isset($_GET['deleted'])): ?>
        <p style="color: red;">🗑️ Réponse supprimée !</p>
    <?php elseif (isset($_GET['updated'])): ?>
        <p style="color: blue;">✏️ Réponse modifiée avec succès !</p>
    <?php endif; ?>

    <!-- Formulaire d'ajout ou de modification -->
    <h2><?= $editData ? "Modifier la réponse" : "Ajouter une réponse" ?></h2>
    

<form action="<?= $editData ? '../../view/backend/update_reponse.php' : '../../view/backend/ajouter_reponse.php' ?>" method="POST">
    
    
        
        <?php if (!$editData): ?>
            <input type="number" name="idreclamation" placeholder="ID Réclamation" required>
            <input type="number" name="id" placeholder="ID Utilisateur" required>
        <?php else: ?>
            <input type="hidden" name="idreponse" value="<?= htmlspecialchars($editData['idreponse']) ?>">
        <?php endif; ?>

        <textarea name="message" placeholder="Votre réponse..." required><?= $editData ? htmlspecialchars($editData['message']) : '' ?></textarea>

        <select name="typerep" required>
            <option value="">-- Sélectionner un type --</option>
            <option value="en cours" <?= $editData && $editData['typerep'] == 'en cours' ? 'selected' : '' ?>>En cours</option>
            <option value="resolue" <?= $editData && $editData['typerep'] == 'resolue' ? 'selected' : '' ?>>Résolue</option>
            <option value="rejeter" <?= $editData && $editData['typerep'] == 'rejeter' ? 'selected' : '' ?>>Rejetée</option>
        </select>

        <button type="submit"><?= $editData ? 'Modifier' : 'Ajouter' ?></button>
    </form>

    <!-- Liste des réponses -->
    <h2>Liste des réponses</h2>

    <div id="reponseList">
        <?php foreach ($reponses as $rep): ?>
            <div class="announcement-card">
                <p><strong>ID Réclamation :</strong> <?= htmlspecialchars($rep['idreclamation']) ?></p>
                <p><strong>Message :</strong> <?= htmlspecialchars($rep['message']) ?></p>
                <p><strong>Date :</strong> <?= htmlspecialchars($rep['daterep']) ?></p>
                <p><strong>Type :</strong> <?= htmlspecialchars($rep['typerep']) ?></p>

                <div style="margin-top: 10px;">
                    <!-- Bouton Modifier -->
                    <a href="reponse.php?edit=<?= $rep['idreponse'] ?>" style="color: blue;">✏️ Modifier</a>

                    <!-- Formulaire de suppression -->
                    <form method="POST" action="../../view/backend/delete_reponse.php" onsubmit="return confirm('Voulez-vous vraiment supprimer cette réponse ?');" style="display: inline;">
                        <input type="hidden" name="idreponse" value="<?= $rep['idreponse'] ?>">
                        <button type="submit" style="background: red; color: white;">🗑️ Supprimer</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</main>

<footer>
    &copy; 2025 Startup Academy. Tous droits réservés.
</footer>

</body>
</html>
