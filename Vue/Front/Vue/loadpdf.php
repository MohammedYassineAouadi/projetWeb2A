<?php
header("Access-Control-Allow-Origin: *");

if (isset($_GET['file'])) {
    $file = basename($_GET['file']);
    $path = '../uploads/' . $file;

    if (file_exists($path)) {
        header('Content-Type: application/pdf');
        readfile($path);
    } else {
        http_response_code(404);
        echo "Fichier introuvable.";
    }
} else {
    http_response_code(400);
    echo "Paramètre manquant.";
}
