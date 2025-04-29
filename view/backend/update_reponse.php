<?php
require_once '../../controllers/ReponseController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new ReponseController();
    
    // Créer un tableau associatif avec les données POST
    $data = [
        'idreponse' => $_POST['idreponse'],
        'message' => $_POST['message'],
        'typerep' => $_POST['typerep']
    ];

    // Passer ce tableau à la méthode updateReponse
    $controller->updateReponse($data);

    // Rediriger après la mise à jour
    header('Location: ../frontend/reponse.php?updated=1');
    exit();
}
?>
