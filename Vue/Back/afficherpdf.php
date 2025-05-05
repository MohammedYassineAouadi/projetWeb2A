<?php
require_once(__DIR__ . "/../../config.php"); // Vérifie le chemin correct

// Obtenir la connexion PDO
$pdo = config::getConnexion();

// Récupérer les PDFs
$sql = "SELECT * FROM pdf"; // Remplace 'pdfs' par le nom réel de ta table
$stmt = $pdo->prepare($sql);
$stmt->execute();
$pdfs = $stmt->fetchAll();

// Retourner les données en JSON (si utilisé en AJAX)
header('Content-Type: application/json');
echo json_encode($pdfs);
/*include 'PDF Liste.html';*/
?>
