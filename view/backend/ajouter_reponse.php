<?php
require_once '../../controllers/ReponseController.php';

$controller = new ReponseController();

// Correction ici : appel correct de la méthode addReponse
$controller->addReponse([
    'idreclamation' => $_POST['idreclamation'],
    'id' => $_POST['id'],
    'message' => $_POST['message'],
    'typerep' => $_POST['typerep']
]);


header('Location: ../frontend/reponse.php?success=1');
exit();
?>
