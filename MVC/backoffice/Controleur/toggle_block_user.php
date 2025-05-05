<?php
session_start();
require_once __DIR__ . '/../Model/utilisateur.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../../frontoffice/Vue/connexion.php');
    exit;
}

$utilisateur = new UtilisateurBack();

if (isset($_GET['id']) && isset($_GET['action'])) {
    $id = intval($_GET['id']);
    $action = $_GET['action'];

    if ($action == 'bloquer') {
        $utilisateur->bloquerUtilisateur($id);
    } elseif ($action == 'debloquer') {
        $utilisateur->debloquerUtilisateur($id);
    }

    header('Location: ../Vue/dashboard.php');
    exit;
} else {
    header('Location: ../Vue/dashboard.php');
    exit;
}
?>
