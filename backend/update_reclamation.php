<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['idreclamation'];
    $sujet = $_POST['sujet'];
    $categorie = $_POST['categorie'];
    $statut = $_POST['statut'];

    try {
        $stmt = $pdo->prepare("UPDATE reclamation SET contenu = ?, type = ?, statut = ? WHERE idreclamation = ?");
        $stmt->execute([$sujet, $categorie, $statut, $id]);
        header('Location: ../frontend/index.php?success=update');
        exit;
    } catch (PDOException $e) {
        echo 'Erreur de mise à jour : ' . $e->getMessage();
    }
}
?>
