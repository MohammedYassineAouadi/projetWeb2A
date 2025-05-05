<?php
session_start();
require_once __DIR__ . '/../Model/utilisateur.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../../frontoffice/Vue/connexion.php');
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $utilisateur = new UtilisateurBack();
    $utilisateur->supprimerUtilisateur($id);

    header('Location: ../Vue/dashboard.php?deleted=1');
    exit;
} else {
    header('Location: ../Vue/dashboard.php');
    exit;
}
?>
