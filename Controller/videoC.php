<?php
require_once(__DIR__ . "/../Model/video.php");

require_once __DIR__ . '/../config.php';  // Assurez-vous que le chemin est correct

class VideoC {
    public function ajouterVideo($video) {
        $titre = $video->getTitre();
        $description = $video->getDescription();
        $url = $video->getUrl();
        $duree = $video->getDuree();
        $date_ajout = $video->getDateAjout();
        $id_pdf = $video->getIdPdf();

        // Connexion à la base de données
        $db = config::getConnexion();

        // Vérifier si la table existe, sinon la créer
        $sqlCheckTable = "SELECT 1 FROM video LIMIT 1";
        try {
            $db->query($sqlCheckTable);
        } catch (Exception $e) {
            // Création de la table Video si elle n'existe pas
            $sqlCreateTable = "CREATE TABLE video (
                id_video INT(11) AUTO_INCREMENT PRIMARY KEY,
                titre VARCHAR(255) NOT NULL,
                description VARCHAR(255) NOT NULL,
                url VARCHAR(255) NOT NULL,
                duree VARCHAR(255) NOT NULL,
                date_ajout DATE NOT NULL,
                id_pdf INT(11) NOT NULL,
                FOREIGN KEY (id_pdf) REFERENCES pdf(id_pdf) ON DELETE CASCADE
            )";
            $db->query($sqlCreateTable);
        }

        // Insérer les données dans la table video
        $sqlInsert = "INSERT INTO video (titre, description, url, duree, date_ajout, id_pdf) 
                      VALUES (:titre, :description, :url, :duree, :date_ajout, :id_pdf)";
        try {
            $reqInsert = $db->prepare($sqlInsert);
            $reqInsert->bindValue(':titre', $titre);
            $reqInsert->bindValue(':description', $description);
            $reqInsert->bindValue(':url', $url);
            $reqInsert->bindValue(':duree', $duree);
            $reqInsert->bindValue(':date_ajout', $date_ajout);
            $reqInsert->bindValue(':id_pdf', $id_pdf);
            $reqInsert->execute();
            return true;
        } catch (Exception $e) {
            echo 'Erreur: ' . $e->getMessage();
            return false;
        }
    }
    public function afficherVideo() {
        $db = config::getConnexion(); // Connexion à la base de données
        $sql = "SELECT * FROM video ORDER BY id_video DESC"; // Récupérer tous les PDFs
        try {
            $query = $db->query($sql);
            return $query->fetchAll(PDO::FETCH_ASSOC); // Retourne un tableau associatif
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    public function deleteVideo($id_video)
    {
        $sql = "DELETE FROM video WHERE id_video =:id_video";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id_video', $id_video);
        try {
            $req->execute();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    public function updateVideo($video, $id_video)
{
    try {
        $db = config::getConnexion();
        $query = $db->prepare(
            'UPDATE video SET 
                titre = :titre, 
                description = :description, 
                url = :url, 
                duree = :duree, 
                date_ajout = :date_ajout 
            WHERE id_video = :id_video'
        );

        $query->execute([
            'id_video' => $id_video,
            ':titre' => $video->getTitre(),
            ':description' => $video->getDescription(),
            ':url' => $video->getUrl(),
            ':duree' => $video->getDuree(),
            ':date_ajout' => $video->getDateAjout()
        ]);

        echo $query->rowCount() . " vidéo(s) mise(s) à jour avec succès.<br>";
    } catch (PDOException $e) {
        echo "Erreur de mise à jour de la vidéo : " . $e->getMessage();
    }
}

public function getVideoById($id)
{
    $sql = "SELECT * FROM video WHERE id_video = :id";
    $db = config::getConnexion();
    try {
        $query = $db->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        die(' Erreur lors de la récupération de la vidéo : ' . $e->getMessage());
    }
}

}
?>
