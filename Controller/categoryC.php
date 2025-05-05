<?php
require_once __DIR__ . '/../config.php';  // Assurez-vous que le chemin est correct
require_once(__DIR__ . "/../Model/categoryC.php");


class CategoryC {

    // Afficher toutes les catégories
    public function getAllCategories() {
        try {
            $pdo = config::getConnexion();
            $query = $pdo->prepare("SELECT * FROM category");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Afficher les PDF d'une catégorie spécifique
    public function getPdfsByCategory($idCategory) {
        try {
            $pdo = config::getConnexion();
            $query = $pdo->prepare("SELECT * FROM pdf WHERE id_category = :id");
            $query->execute(['id' => $idCategory]);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
