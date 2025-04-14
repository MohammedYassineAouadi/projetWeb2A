<?php
require_once(__DIR__ . "/../Model/Pdf.php");
require_once __DIR__ . '/../config.php';  // Assurez-vous que le chemin est correct
class PdfC{
    public function ajouterPdf($pdf) {
        $titre = $pdf->getTitre();
        $url = $pdf->getUrl();
        $Type = $pdf->getType();


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
                Type VARCHAR(255) NOT NULL
            )";
            $db->query($sqlCreateTable);
        }

        // Insérer les données dans la table PDF
        $sqlInsert = "INSERT INTO pdf (titre, url,Type) VALUES (:titre, :url, :Type)";
        try {
            $reqInsert = $db->prepare($sqlInsert);
            $reqInsert->bindValue(':titre', $titre);
            $reqInsert->bindValue(':url', $url);
            $reqInsert->bindValue(':Type', $Type);
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
                url = :url
            WHERE id_pdf = :id'
        );

        $query->execute([
            'id' => $id,
            'titre' => $pdf->getTitre(),
            'Type' => $pdf->getType(),
            'url' => $pdf->getUrl()
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



}
?>

