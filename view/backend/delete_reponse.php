<?php
require_once '../../controllers/ReponseController.php'; 

if (isset($_POST['idreponse'])) {
    $controller = new ReponseController();
    $controller->deleteReponse($_POST['idreponse']);
    header('Location: ../frontend/reponse.php?deleted=1');
    exit();
}
?>
