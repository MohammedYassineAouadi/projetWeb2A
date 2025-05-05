<?php
// searchPdfAction.php
require_once "../../../Controller/pdfC.php";

// Vérifiez si une requête de recherche est envoyée
if (isset($_GET['query']) && !empty($_GET['query'])) {
    $query = $_GET['query']; // La valeur de recherche envoyée par AJAX

    // Instanciation du contrôleur PDF
    $pdfController = new PdfC();

    // Récupérer les PDFs filtrés par titre
    $pdfs = $pdfController->searchPdfsByTitle($query);

    // Vérifiez s'il y a des résultats
    if (!empty($pdfs)) {
        foreach ($pdfs as $pdf) {
            echo '<div class="pdf-result">';
            echo '<h4>' . htmlspecialchars($pdf['titre']) . '</h4>';
            echo '<p>' . htmlspecialchars($pdf['Type']) . '</p>';
            echo '<p>' . htmlspecialchars($pdf['description_P']) . '</p>';
            echo '<a href="voirPdf.php?id_pdf=' . htmlspecialchars($pdf['id_pdf']) . '&url=' . urlencode($pdf['url']) . '" class="btn btn-warning btn-orange-dark mt-3">Voir le PDF</a>';
            echo '</div>';
        }
    } else {
        // Si aucun résultat trouvé
        echo '<p>Aucun PDF trouvé pour cette recherche.</p>';
    }
}
?>
