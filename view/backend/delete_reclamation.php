<?php
require_once 'config.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idreclamation = $_POST['idreclamation'] ?? '';

    if (!empty($idreclamation)) {
        try {
           
            $stmt = $pdo->prepare("DELETE FROM reclamation WHERE idreclamation = :idreclamation");
            $stmt->bindParam(':idreclamation', $idreclamation, PDO::PARAM_INT);
            $stmt->execute();

           
            header("Location: ../view/frontend/index.php?success=1");
            exit();
        } catch (PDOException $e) {
           
            header("Location: ../frontend/index.php?error=1");
            exit();
        }
    }
}
?>
