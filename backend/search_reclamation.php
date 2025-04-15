<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $keyword = trim($_POST['search']);

    try {
        $stmt = $pdo->prepare("SELECT * FROM reclamation WHERE contenu LIKE :keyword OR type LIKE :keyword ORDER BY datereclamation DESC");
        $stmt->execute(['keyword' => "%$keyword%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Retourner les résultats au format JSON
        echo json_encode($results);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Erreur : ' . $e->getMessage()]);
    }
}
?>
