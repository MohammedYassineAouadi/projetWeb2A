<?php
require_once 'config.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idreclamation = $_POST['idreclamation'] ?? '';

    if (!empty($idreclamation)) {
        try {
            // Prepare and execute the delete query
            $stmt = $pdo->prepare("DELETE FROM reclamation WHERE idreclamation = :idreclamation");
            $stmt->bindParam(':idreclamation', $idreclamation, PDO::PARAM_INT);
            $stmt->execute();

            // Redirect to the home page with a success message
            header("Location: ../frontend/index.php?deleted=1");
            exit();
        } catch (PDOException $e) {
            // If there's an error, redirect with error
            header("Location: ../frontend/index.php?error=1");
            exit();
        }
    }
}
?>
