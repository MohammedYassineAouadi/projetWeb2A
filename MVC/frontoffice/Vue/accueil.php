<?php
session_start();

// Protection : empêcher l'accès si non connecté
if (!isset($_SESSION['user'])) {
    header('Location: connexion.php');
    exit;
}

// Récupérer les informations utilisateur
$prenom = $_SESSION['user']['prenom'];
$nom = $_SESSION['user']['nom'];
$role = $_SESSION['user']['role'];  // <<< Ajouter cette ligne pour récupérer le rôle !

require_once __DIR__ . '/../Controleur/check_ban.php';
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - Startup Academy</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>

<div class="form-container">
    <h2>Bienvenue <?php echo htmlspecialchars($prenom . ' ' . $nom); ?> !</h2>

    <p>Vous êtes connecté en tant que <strong><?php echo htmlspecialchars($role); ?></strong>.</p>

    <a href="../../logout.php">
        <button>Se déconnecter</button>
    </a>
</div>

</body>
</html>
