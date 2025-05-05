<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['url'])) {
    $url = $_GET['url'];
    echo "URL reçue : " . htmlspecialchars($url) . "<br>";  // Afficher l'URL reçue pour débogage

    $parsedUrl = parse_url($url);
    $localPath = $_SERVER['DOCUMENT_ROOT'] . $parsedUrl['path'];
    echo "Chemin local : " . $localPath . "<br>";  // Afficher le chemin local

    if (file_exists($localPath)) {
        echo "Fichier trouvé : " . $localPath . "<br>";  // Vérifier si le fichier existe
        header('Content-Type: application/pdf');
        readfile($localPath);
    } else {
        echo "Fichier introuvable : $localPath";  // Afficher un message d'erreur si le fichier n'est pas trouvé
        http_response_code(404);
    }
    exit;
}
?>
