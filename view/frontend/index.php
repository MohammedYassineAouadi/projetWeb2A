<?php
require_once '../backend/config.php';
require_once '../../controllers/ReclamationController.php';

$controller = new ReclamationController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Soumettre une réclamation
    if (isset($_POST['sujet'], $_POST['categorie'], $_POST['message'])) {
        $sujet = trim($_POST['sujet']); // Enlever les espaces inutiles
        $categorie = trim($_POST['categorie']);
        $message = trim($_POST['message']);

        // Vérification des champs
        if (empty($sujet) || empty($categorie) || empty($message)) {
            echo "<script>alert('Tous les champs doivent être remplis !');</script>"; // Affiche l'alerte
        } else {
            // Si tout est valide, soumettre la réclamation
            $controller->submit($sujet, $categorie, $message);
            header('Location: index.php?success=1');
            exit();
        }
    }

    // Supprimer une réclamation
    if (isset($_POST['delete'])) {
        $id = $_POST['delete'];
        $controller->delete($id);
        header('Location: index.php?success=delete');
        exit();
    }

    // Modifier une réclamation
    if (isset($_POST['update_id'], $_POST['update_contenu'], $_POST['update_type'], $_POST['update_statut'])) {
        $id = $_POST['update_id'];
        $contenu = $_POST['update_contenu'];
        $type = $_POST['update_type'];
        $statut = $_POST['update_statut'];
        $controller->update($id, $contenu, $type, $statut);
        header('Location: index.php?success=update');
        exit();
    }
}

// Afficher toutes les réclamations
$reclamations = $controller->read();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Réclamations</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>STARTUP ACADEMY</h1>
</header>

<main class="container">
    <h2>Soumettre une réclamation</h2>

    <?php if (isset($_GET['success'])): ?>
        <p style="color: green;">✅ Réclamation traitée avec succès !</p>
    <?php endif; ?>

    <form action="index.php" method="POST">
        <input type="text" name="sujet" placeholder="Sujet de la réclamation">
        <select name="categorie">
            <option value="">Catégorie</option>
            <option value="plainte">plainte</option>
            <option value="suggestion">suggestion</option>
            <option value="information">information</option>
        </select>
        <textarea name="message" placeholder="Détaillez votre réclamation ici..."></textarea>
        <button type="submit">Envoyer</button>
    </form>

    <h2>Réclamations reçues</h2>
    <div id="reclamationsList">
        <?php foreach ($reclamations as $row): ?>
            <div class="announcement-card">
                <h3><?= htmlspecialchars($row['contenu']) ?></h3>
                <p><strong>Date :</strong> <?= htmlspecialchars($row['datereclamation']) ?></p>
                <p><strong>Type :</strong> <?= htmlspecialchars($row['type']) ?></p>
                <p><strong>Statut :</strong> <?= htmlspecialchars($row['statut']) ?></p>

                <!-- Formulaire de suppression -->
                <form method="POST" action="index.php" onsubmit="return confirm('Supprimer cette réclamation ?');">
                    <input type="hidden" name="delete" value="<?= $row['idreclamation'] ?>">
                    <button type="submit" style="background: red; color: white;">Supprimer</button>
                </form>

                <!-- Formulaire de modification -->
                <form method="POST" action="index.php">
                    <input type="hidden" name="update_id" value="<?= $row['idreclamation'] ?>">
                    <input type="text" name="update_contenu" value="<?= htmlspecialchars($row['contenu']) ?>">
                    <input type="text" name="update_type" value="<?= htmlspecialchars($row['type']) ?>">
                    <select name="update_statut">
                        <option value="En attente" <?= $row['statut'] == 'En attente' ? 'selected' : '' ?>>En attente</option>
                        <option value="en cours" <?= $row['statut'] == 'en cours' ? 'selected' : '' ?>>en cours</option>
                        <option value="resolue" <?= $row['statut'] == 'resolue' ? 'selected' : '' ?>>résolue</option>
                    </select>
                    <button type="submit" style="background: blue; color: white;">Modifier</button>
                </form>

                <!-- Voir la réponse -->
                <form method="GET" action="voir_reponse.php" style="margin-top: 10px;">
                    <input type="hidden" name="idreclamation" value="<?= $row['idreclamation'] ?>">
                    <button type="submit" style="background: purple; color: white;">👁️ Voir Réponse</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<footer>
    &copy; 2025 Startup Academy. Tous droits réservés.
</footer>
</body>
</html>
