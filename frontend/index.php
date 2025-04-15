<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion des Réclamations</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>STARTUP ACADEMY</h1>
    <nav>
        <a href="#">Accueil</a>
        <a href="#">Réclamations</a>
        <a href="#">Cours</a>
        <a href="#">Contact</a>
    </nav>
</header>

<main class="container">
    <h2>Soumettre une réclamation</h2>

    <?php if (isset($_GET['success'])): ?>
        <p style="color: green;">✅ Réclamation envoyée avec succès !</p>
    <?php elseif (isset($_GET['success']) && $_GET['success'] === 'update'): ?>
        <p style="color: green;">✅ Réclamation mise à jour avec succès !</p>
    <?php endif; ?>

    <form action="../backend/submit_reclamation.php" method="POST">
        <input type="text" name="sujet" placeholder="Sujet de la réclamation" required>

        <select name="categorie" required>
            <option value="">Catégorie</option>
            <option value="Technique">Technique</option>
            <option value="Administratif">Administratif</option>
            <option value="Autre">Autre</option>
        </select>

        <textarea name="message" placeholder="Détaillez votre réclamation ici..." required></textarea>
        <button type="submit">Envoyer</button>
    </form>

    <h2>Réclamations reçues</h2>
    <div id="reclamationsList">
        <?php
        require_once '../backend/config.php';

        try {
            $stmt = $pdo->query("SELECT * FROM reclamation ORDER BY datereclamation DESC");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<div class="announcement-card">';

                if (isset($_GET['edit']) && $_GET['edit'] == $row['idreclamation']) {
                    echo '<form action="../backend/update_reclamation.php" method="POST">';
                    echo '<input type="hidden" name="idreclamation" value="' . $row['idreclamation'] . '">';
                    echo '<input type="text" name="sujet" value="' . htmlspecialchars($row['contenu']) . '" required>';

                    echo '<select name="categorie" required>';
                    $types = ['Plainte', 'Suggestion', 'Information'];
                    foreach ($types as $type) {
                        $selected = ($row['type'] == $type) ? 'selected' : '';
                        echo "<option value=\"$type\" $selected>$type</option>";
                    }
                    echo '</select>';

                    echo '<select name="statut" required>';
                    $statuts = ['en attente', 'en cours', 'resolue'];
                    foreach ($statuts as $statut) {
                        $selected = ($row['statut'] == $statut) ? 'selected' : '';
                        echo "<option value=\"$statut\" $selected>$statut</option>";
                    }
                    echo '</select>';

                    echo '<button type="submit">Mettre à jour</button>';
                    echo '</form>';
                } else {
                    echo '<h3>' . htmlspecialchars($row['contenu']) . '</h3>';
                    echo '<p><strong>Date :</strong> ' . htmlspecialchars($row['datereclamation']) . '</p>';
                    echo '<p><strong>Type :</strong> ' . htmlspecialchars($row['type']) . '</p>';
                    echo '<p><strong>Statut :</strong> ' . htmlspecialchars($row['statut']) . '</p>';

                    echo '<a href="?edit=' . $row['idreclamation'] . '"><button>Modifier</button></a>';

                    echo '<form action="../backend/delete_reclamation.php" method="POST" style="display:inline;">
                            <input type="hidden" name="idreclamation" value="' . $row['idreclamation'] . '">
                            <button type="submit" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer cette réclamation ?\')">Supprimer</button>
                          </form>';
                }

                echo '</div>';
            }
        } catch (PDOException $e) {
            echo '<p>Erreur lors du chargement des réclamations : ' . $e->getMessage() . '</p>';
        }
        ?>
    </div>
</main>

<footer>
    &copy; 2025 Startup Academy. Tous droits réservés.
</footer>

</body>
</html>
