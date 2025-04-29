<?php
require_once '../../model/ReponseModel.php';

class ReponseController {
    private $model;

    public function __construct() {
        $this->model = new ReponseModel();
    }

    public function getAllReponses() {
        return $this->model->readAll();
    }

    public function getReponseById($idreponse) {
        return $this->model->getById($idreponse);
    }

    public function addReponse($data) {
        // Vérification du type de données avant de passer à la méthode du modèle
        if (is_array($data) && isset($data['idreclamation'], $data['id'], $data['message'], $data['typerep'])) {
            // Ajout des vérifications de type si nécessaire
            return $this->model->add($data['idreclamation'], $data['id'], $data['message'], $data['typerep']);
        } else {
            // Gérer l'erreur si les données ne sont pas valides
            throw new Exception("Données invalides pour l'ajout de réponse.");
        }
    }

    public function updateReponse($data) {
        // Vérification du type de données avant d'essayer de les utiliser
        if (is_array($data) && isset($data['idreponse'], $data['message'], $data['typerep'])) {
            // Ajouter des vérifications de type, si nécessaire
            if (!is_numeric($data['idreponse'])) {
                throw new Exception("L'ID de la réponse doit être un nombre.");
            }
            
            // Appel au modèle pour mettre à jour la réponse
            return $this->model->update($data['idreponse'], $data['message'], $data['typerep']);
        } /*else {
            // Gérer l'erreur si les données ne sont pas valides
            throw new Exception("Données invalides pour la mise à jour de la réponse.");
        }*/
    }
    

    public function deleteReponse($idreponse) {
        return $this->model->delete($idreponse);
    }
    public function getReponseByReclamationId($idreclamation) {
        return $this->model->getByReclamationId($idreclamation);
    }
}



?>
