<?php
require_once '../../controllers/ReclamationController.php';

$controller = new ReclamationController();
$reclamations = $controller->read();

// Compter les réclamations par type
$typeCounts = [];
$statutCounts = [];

foreach ($reclamations as $rec) {
    // Type
    $type = $rec['type'];
    $typeCounts[$type] = ($typeCounts[$type] ?? 0) + 1;

    // Statut
    $statut = $rec['statut'];
    $statutCounts[$statut] = ($statutCounts[$statut] ?? 0) + 1;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Analytique</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
<header>
    <h1>📊 Dashboard Analytique des Réclamations</h1>
</header>

<main class="container" style="text-align:center;">
    <div style="display: flex; justify-content: center; gap: 50px; flex-wrap: wrap;">
        <div>
            <h3>Répartition par Type</h3>
            <canvas id="reclamationsChart" width="400" height="300"></canvas>
        </div>
        <div>
            <h3>Répartition par Statut</h3>
            <canvas id="statutChart" width="400" height="300"></canvas>
        </div>
    </div>

    <a href="liste_reclamations_importance.php">
        <button style="margin-top: 30px; padding: 10px 20px;">⬅️ Retour aux Réclamations</button>
    </a>
</main>

<script>
    const typeLabels = <?= json_encode(array_keys($typeCounts)) ?>;
    const typeData = <?= json_encode(array_values($typeCounts)) ?>;

    const statutLabels = <?= json_encode(array_keys($statutCounts)) ?>;
    const statutData = <?= json_encode(array_values($statutCounts)) ?>;

    // Graphique par Type (Barres)
    new Chart(document.getElementById('reclamationsChart'), {
        type: 'bar',
        data: {
            labels: typeLabels,
            datasets: [{
                label: 'Nombre de réclamations',
                data: typeData,
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Graphique par Statut (Camembert)
    new Chart(document.getElementById('statutChart'), {
        type: 'pie',
        data: {
            labels: statutLabels,
            datasets: [{
                label: 'Réclamations par statut',
                data: statutData,
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#8E44AD', '#2ECC71'
                ],
                hoverOffset: 10
            }]
        }
    });
</script>
</body>
</html>
