<?php
require_once(__DIR__ . "/../Model/Pdf.php");
require_once __DIR__ . '/../config.php';  // Assurez-vous que le chemin est correct
class PdfC{
    public function ajouterPdf($pdf) {
        $titre = $pdf->getTitre();
        $url = $pdf->getUrl();
        $Type = $pdf->getType();
        $description_P = $pdf->getdescription_P();
        $id_category = $pdf->getIdCategory();




        // Connexion à la base de données
        $db = config::getConnexion();

        // Vérifier si la table existe, sinon la créer
        $sqlCheckTable = "SELECT 1 FROM pdf LIMIT 1";
        try {
            $db->query($sqlCheckTable);
        } catch (Exception $e) {
            // Création de la table PDF si elle n'existe pas
            $sqlCreateTable = "CREATE TABLE pdf (
                id_pdf INT(11) AUTO_INCREMENT PRIMARY KEY,
                titre VARCHAR(255) NOT NULL UNIQUE,
                url VARCHAR(255) NOT NULL,
                Type VARCHAR(255) NOT NULL,
                description_P VARCHAR(200) NOT NULL,
                FOREIGN KEY (id_category) REFERENCES category(id_category) ON DELETE CASCADE


            )";
            $db->query($sqlCreateTable);
        }

        // Insérer les données dans la table PDF
        $sqlInsert = "INSERT INTO pdf (titre, url,Type, description_P,id_category) VALUES (:titre, :url, :Type , :description_P , :id_category)";
        try {
            $reqInsert = $db->prepare($sqlInsert);
            $reqInsert->bindValue(':titre', $titre);
            $reqInsert->bindValue(':url', $url);
            $reqInsert->bindValue(':Type', $Type);
            $reqInsert->bindValue(':description_P', $description_P);
            $reqInsert->bindValue(':id_category', $id_category);


            $reqInsert->execute();
            return true;
        } catch (Exception $e) {
            echo 'Erreur: '.$e->getMessage();
            return false;
        }
    }
    
    public function afficherPdfs() {
        $db = config::getConnexion(); // Connexion à la base de données
        $sql = "SELECT * FROM pdf ORDER BY id_pdf DESC"; // Récupérer tous les PDFs
        try {
            $query = $db->query($sql);
            return $query->fetchAll(PDO::FETCH_ASSOC); // Retourne un tableau associatif
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
    public function deletePdfs($id_pdf)
    {
        $sql = "DELETE FROM pdf WHERE id_pdf =:id_pdf";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id_pdf', $id_pdf);
        try {
            $req->execute();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
    public function updatePdf($pdf, $id)
{
    try {
        $db = config::getConnexion();
        $query = $db->prepare(
            'UPDATE pdf SET 
                titre = :titre, 
                Type = :Type, 
                url = :url,
                description_P = :description_P

            WHERE id_pdf = :id'
        );

        $query->execute([
            'id' => $id,
            'titre' => $pdf->getTitre(),
            'Type' => $pdf->getType(),
            'url' => $pdf->getUrl(),
            'description_P' => $pdf->getdescription_P()

        ]);

        echo $query->rowCount() . " enregistrement(s) mis à jour avec succès.<br>";
    } catch (PDOException $e) {
        echo "Erreur de mise à jour : " . $e->getMessage();
    }

}

public function getPdfById($id)
{
    $sql = "SELECT * FROM pdf WHERE id_pdf = :id";
    $db = config::getConnexion();
    try {
        $query = $db->prepare($sql);
        $query->bindParam(':id', $id);
        $query->execute();
        return $query->fetch();
    } catch (Exception $e) {
        die('Erreur: ' . $e->getMessage());
    }
}

public function searchPdfsByTitle($query) {
    $sql = "SELECT * FROM pdf WHERE titre LIKE :query";
    $db = config::getConnexion();  // Connexion à la base de données
    try {
        // Préparation de la requête
        $stmt = $db->prepare($sql);
        // On lie la valeur de la recherche (en encodant les caractères spéciaux)
        $stmt->bindValue(':query', '%' . $query . '%', PDO::PARAM_STR);
        // Exécution de la requête
        $stmt->execute();
        // Récupération des résultats sous forme de tableau associatif
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        die('Erreur: ' . $e->getMessage());
    }
}
public function getProgressByUser($userId) {
    $sql = "SELECT id_pdf, pages_lues, pourcentage FROM progression_lecture WHERE id = ?";
    $db = config::getConnexion();  // Connexion à la base de données

    $stmt = $db->prepare($sql);
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function saveProgress($id, $id_pdf, $pages_lues)
{
    include '../../config.php'; // ton fichier pour connexion base

    $sql = "INSERT INTO progression (id, id_pdf, pages_lues, pourcentage)
            VALUES (:id, :id_pdf, :pages_lues, :pourcentage)
            ON DUPLICATE KEY UPDATE pages_lues = :pages_lues, pourcentage = :pourcentage";

    $stmt = $conn->prepare($sql);

    // Calcul du pourcentage lu
    $stmt_pdf = $conn->prepare("SELECT nombre_pages FROM pdf WHERE id_pdf = :id_pdf");
    $stmt_pdf->execute([':id_pdf' => $pdf_id]);
    $pdf = $stmt_pdf->fetch(PDO::FETCH_ASSOC);
    $total_pages = $pdf ? $pdf['nombre_pages'] : 1; // éviter division par 0

    $pourcentage = ($pages_lues / $total_pages) * 100;

    $stmt->execute([
        ':utilisateur_id' => $utilisateur_id,
        ':pdf_id' => $pdf_id,
        ':pages_lues' => $pages_lues,
        ':pourcentage' => $pourcentage
    ]);
}

}
?>

