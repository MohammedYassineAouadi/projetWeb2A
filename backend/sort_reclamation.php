<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sort'])) {
    $sort = $_POST['sort'];

    switch ($sort) {
        case 'date_desc':
            $query = "SELECT * FROM reclamation ORDER BY datereclamation DESC";
            break;
        case 'date_asc':
            $query = "SELECT * FROM reclamation ORDER BY datereclamation ASC";
            break;
        case 'alpha_asc':
            $query = "SELECT * FROM reclamation ORDER BY contenu ASC";
            break;
        case 'alpha_desc':
            $query = "SELECT * FROM reclamation ORDER BY contenu DESC";
            break;
        default:
            $query = "SELECT * FROM reclamation";
            break;
    }

    try {
        $stmt = $pdo->query($query);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($results);
    } catch (PDOException $e) {
        echo json_encode([]);
    }
}
?>
