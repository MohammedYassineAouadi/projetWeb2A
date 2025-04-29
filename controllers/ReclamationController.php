<?php
require_once '../backend/config.php';
require_once __DIR__ . '/../model/ReclamationModel.php';
;

class ReclamationController {
    private $model;

    public function __construct() {
        global $pdo;
        $this->model = new ReclamationModel($pdo);
    }

    // Soumettre une réclamation
    public function submit($sujet, $categorie, $message) {
        $date = date('Y-m-d');
        $type = $categorie; // On utilise directement la catégorie comme type
        return $this->model->addReclamation($message, $type, $date);
    }

    // Lire toutes les réclamations
    public function read() {
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
}
