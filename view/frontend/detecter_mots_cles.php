<?php
function detecter_mots_cles($contenu) {
    // Liste de mots-clés importants à détecter
    $mots_cles = ['urgent', 'important', 'immédiat', 'grave', 'critique', 'prioritaire'];
    $trouve = [];

    if (!empty($contenu)) {
        foreach ($mots_cles as $mot) {
            if (stripos($contenu, $mot) !== false) {
                $trouve[] = $mot;
            }
        }
    }

    return $trouve;
}
?>
