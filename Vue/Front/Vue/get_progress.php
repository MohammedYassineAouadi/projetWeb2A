<?php
// get_progress.php
// Ce script récupère la progression de lecture depuis la base de données

// Headers pour permettre les requêtes AJAX
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once(__DIR__ . "/../../../config.php");

// Récupérer les paramètres de la requête
$pdf_id = isset($_GET['id_pdf']) ? $_GET['id_pdf'] : null;
$user_id = isset($_GET['id']) ? $_GET['id'] : 1; // ID utilisateur par défaut

if (!$pdf_id) {
    echo json_encode([
        "success" => false,
        "message" => "ID du PDF non spécifié"
    ]);
    exit();
}

// Échapper les données pour éviter les injections SQL
$pdf_id = $conn->real_escape_string($pdf_id);
$user_id = $conn->real_escape_string($user_id);

// Récupérer la progression de l'utilisateur pour ce PDF
$sql = "SELECT pages_lues, total_pages, pourcentage FROM progression_lecture 
        WHERE id = ? AND id_pdf = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $pdf_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode([
        "success" => true,
        "pages_lues" => $row['pages_lues'],
        "total_pages" => $row['total_pages'],
        "pourcentage" => $row['pourcentage']
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Aucune progression trouvée pour cet utilisateur et ce PDF"
    ]);
}

$stmt->close();
?>