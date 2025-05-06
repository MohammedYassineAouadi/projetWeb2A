<?php
require_once '../backend/config.php';
require_once __DIR__ . '/../model/ReclamationModel.php';

class ReclamationController {
    private $model;

    public function __construct() {
        global $pdo;
        $this->model = new ReclamationModel($pdo);
    }

    public function submit($sujet, $categorie, $message) {
        $date = date('Y-m-d');
        $type = $categorie;
        return $this->model->addReclamation($message, $type, $date);
    }

    // Récupérer toutes les réclamations
    public function read() {
        return $this->model->getAllReclamations();
    }

    // Méthode pour récupérer toutes les réclamations directement
    public function getAllReclamations() {
        return $this->model->getAllReclamations();
    }

    // Supprimer une réclamation
    public function delete($id) {
        return $this->model->deleteReclamation($id);
    }

    // Modifier une réclamation
    public function update($id, $contenu, $type, $statut) {
        return $this->model->updateReclamation($id, $contenu, $type, $statut);
    }

    // Rechercher une réclamation
    public function search($query) {
        return $this->model->searchReclamations($query);
    }

    // Trier les réclamations
    public function sort($by) {
        return $this->model->sortReclamations($by);
    }

    // Méthode complète : retourne le lien et le QR code
    public function getReponseLink($idreclamation) {
        $link = $this->model->getReponseLinkByReclamationId($idreclamation);

        if ($link) {
            // Génération QR code en base64
            include_once '../lib/phpqrcode/qrlib.php';
            ob_start();
            \QRcode::png($link, null, QR_ECLEVEL_L, 4);
            $imageData = ob_get_contents();
            ob_end_clean();
            $base64 = base64_encode($imageData);

            return [
                'link' => $link,
                'qrcode' => 'data:image/png;base64,' . $base64
            ];
        } else {
            return [
                'link' => null,
                'message' => 'Aucune réponse disponible pour cette réclamation'
            ];
        }
    }
}
?>
