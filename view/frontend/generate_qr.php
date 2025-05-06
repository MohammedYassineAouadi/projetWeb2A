<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../../controllers/ReponseController.php';

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

header('Content-Type: image/png');

if (!isset($_GET['idreclamation'])) {
    http_response_code(400);
    exit('ID manquant.');
}

$idReclamation = $_GET['idreclamation'];
$url = "http://localhost/gestion_reclamation/view/frontend/voir_reponse.php?idreclamation=" . urlencode($idReclamation);

try {
    $result = Builder::create()
        ->writer(new PngWriter())
        ->data($url)
        ->size(250)
        ->margin(10)
        ->build();

    echo $result->getString();
} catch (Exception $e) {
    http_response_code(500);
    echo "Erreur : " . $e->getMessage();
}
