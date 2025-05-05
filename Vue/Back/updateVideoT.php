<?php
require_once "../../Model/video.php";
require_once "../../Controller/videoC.php";

// Vérifie que tous les champs nécessaires à la vidéo sont présents
if (
    isset($_POST["id_video"], $_POST["id_pdf"], $_POST["titre"], $_POST["description"], $_POST["url"], $_POST["duree"], $_POST["date_ajout"])
) {
    // Nettoyage des données
    $id_video = (int)$_POST["id_video"];
    $titre = trim($_POST["titre"]);
    $description = trim($_POST["description"]);
    $url = trim($_POST["url"]);
    $duree = trim($_POST["duree"]);

    $date = trim($_POST["date_ajout"]);

    // Contrôles de saisie
    $erreurs = [];

if (empty($titre)) {
    $erreurs['titre'] = "❌ Le titre est obligatoire.";
} elseif (strlen($titre) < 3) {
    $erreurs['titre'] = "❌ Le titre doit contenir au moins 3 caractères.";
}

if (empty($description)) {
    $erreurs['description'] = "❌ La description est obligatoire.";
} elseif (strlen($description) < 5) {
    $erreurs['description'] = "❌ La description doit contenir au moins 5 caractères.";
}

if (empty($url)) {
    $erreurs['url'] = "❌ L'URL est obligatoire.";
} elseif (!filter_var($url, FILTER_VALIDATE_URL)) {
    $erreurs['url'] = "❌ L'URL n'est pas valide.";
}
if (empty($duree)) {
    $erreurs['duree'] = "❌ La durée est obligatoire.";
} elseif (!is_numeric($duree) || $duree <= 0) {
    $erreurs['duree'] = "❌ La durée doit être un nombre positif.";
}


if (empty($date)) {
    $erreurs['date_ajout'] = "❌ La date d'ajout est obligatoire.";
} elseif (!DateTime::createFromFormat('Y-m-d', $date)) {
    $erreurs['date_ajout'] = "❌ Le format de la date est invalide (attendu : AAAA-MM-JJ).";
}

// Affichage des erreurs
if (!empty($erreurs)) {
    foreach ($erreurs as $champ => $message) {
        echo "<p style='color:red;'>$message</p>";
    }
    echo "<a href='updateVideo.php?id_video=" . htmlspecialchars($id_video) . "'>⬅️ Retour</a>";
    exit;
}


    // Création et mise à jour de la vidéo
    $video = new Video($titre, $description, $url, $duree,$date, $id_video); // On passe aussi id_pdf au constructeur si la classe le prévoit
    $videoC = new VideoC();
    $videoC->updateVideo($video, $id_video);

    echo "<script>window.location='afficherVideo.php';</script>";
    exit();
} else {
    echo "<p style='color:red;'>Tous les champs doivent être remplis.</p>";
}
?>
