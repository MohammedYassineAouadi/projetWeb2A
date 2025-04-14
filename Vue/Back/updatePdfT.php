<?php
require_once "../../Model/pdf.php";
require_once "../../Controller/pdfC.php";

// Vérifie que tous les champs nécessaires au PDF sont présents
if (
    isset($_POST["id_pdf"], $_POST["titre"], $_POST["Type"], $_POST["url"])
) {
    // Nettoyage des données
    $id_pdf = (int)$_POST["id_pdf"];
    $titre = trim($_POST["titre"]);
    $type = trim($_POST["Type"]);
    $url = trim($_POST["url"]);

    // Contrôles de saisie
    $errors = [];

    if (empty($titre)) {
        $errors['titre'] = " Le titre est obligatoire.";
    } elseif (strlen($titre) < 3) {
        $errors['titre'] = " Le titre doit contenir au moins 3 caractères.";
    }

    if (empty($type) || $type == "Choose...") {
        $errors['Type'] = " Le type est obligatoire.";
    }

    if (empty($url)) {
        $errors['url'] = " L'URL est obligatoire.";
    } elseif (!filter_var($url, FILTER_VALIDATE_URL)) {
        $errors['url'] = " L'URL n'est pas valide.";
    }

    // Affichage des erreurs
    if (!empty($errors)) {
        foreach ($errors as $champ => $message) {
            echo "<p style='color:red;'>$message</p>";
        }
        echo "<a href='updatePdf.php?id_pdf=" . htmlspecialchars($id_pdf) . "'>⬅️ Retour</a>";
        exit;
    }

    // Création et mise à jour du PDF
    $pdf = new Pdf($titre, $type, $url, $id_pdf);
    $pdfC = new PdfC();
    $pdfC->updatePdf($pdf, $id_pdf);

    echo "<script>window.location='Aafficherpdf.php';</script>";
    exit();
} else {
    echo "<p style='color:red;'> Tous les champs doivent être remplis.</p>";
}
?>
