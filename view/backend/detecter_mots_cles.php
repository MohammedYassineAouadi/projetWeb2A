<?php
// Liste des mots-clés et de leur importance
$keywords = [
    'urgent' => 10,  // Très important
    'problème' => 8,
    'plaintes' => 6,
    'doute' => 4,
    'question' => 3,
    'information' => 2,
    'suggérer' => 1
];

// Fonction pour détecter et classer les mots-clés
function detecterMotsCles($texte, $keywords) {
    $results = [];
    $texte = strtolower($texte); // Rendre l'analyse insensible à la casse

    // Parcours des mots-clés définis
    foreach ($keywords as $mot => $importance) {
        // Vérifier si le mot-clé est présent dans le texte
        if (strpos($texte, strtolower($mot)) !== false) {
            $results[] = ['mot' => $mot, 'importance' => $importance];
        }
    }

    // Trier les résultats par ordre d'importance décroissante
    usort($results, function($a, $b) {
        return $b['importance'] - $a['importance'];
    });

    return $results;
}

// Exemple d'utilisation avec une réclamation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['message'])) {
        $texte = $_POST['message'];

        // Analyser le texte pour détecter les mots-clés
        $motsClesDetectes = detecterMotsCles($texte, $keywords);

        // Si des mots-clés sont détectés, les afficher
        if (count($motsClesDetectes) > 0) {
            echo "<h3>Mots-clés détectés et classés par importance :</h3><ul>";
            foreach ($motsClesDetectes as $mot) {
                echo "<li>" . ucfirst($mot['mot']) . " (Importance: " . $mot['importance'] . ")</li>";
            }
            echo "</ul>";
        } else {
            echo "Aucun mot-clé détecté.";
        }
    }
}
?>
