<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Clean and secure user input
    $sujet = trim($_POST['sujet']);
    $categorie = trim($_POST['categorie']);
    $message = trim($_POST['message']);
    $date = date('Y-m-d'); // Current date

    if (!empty($sujet) && !empty($categorie) && !empty($message)) {
        try {
            $sql = "INSERT INTO reclamation (contenu, statut, datereclamation, type)
                    VALUES (:contenu, 'en attente', :datereclamation, :type)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':contenu' => $message,
                ':datereclamation' => $date,
                ':type' => $categorie
            ]);

            // Optional: redirect back to the homepage
            header("Location: ../frontend/index.php?success=1");
            exit();

        } catch (PDOException $e) {
            echo "Erreur lors de l'enregistrement : " . $e->getMessage();
        }
    } else {
        echo "Veuillez remplir tous les champs.";
    }
} else {
    echo "Méthode non autorisée.";
}
?>
<?php
require_once 'controllers/ReclamationController.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sujet = trim($_POST['sujet']);
    $categorie = trim($_POST['categorie']);
    $message = trim($_POST['message']);

    if (!empty($sujet) && !empty($categorie) && !empty($message)) {
        try {
            $contenu = $sujet . " - " . $message;
            ReclamationController::addReclamation($contenu, $categorie);
            header("Location: ../frontend/index.php?success=1");
            exit;
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        }
    } else {
        echo "Veuillez remplir tous les champs.";
    }
} else {
    echo "Méthode non autorisée.";
}
