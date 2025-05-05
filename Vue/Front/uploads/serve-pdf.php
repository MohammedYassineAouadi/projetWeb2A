<?php
// Active l'accès depuis n'importe quelle origine (localhost:3000 inclus)
header("Access-Control-Allow-Origin: *");

// Dis que c’est un fichier PDF
header('Content-Type: application/pdf');

// Empêche le cache (optionnel)
header('Cache-Control: no-cache, must-revalidate');

// Envoie le PDF au navigateur
readfile($_GET['file']);
