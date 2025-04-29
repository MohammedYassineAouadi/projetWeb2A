<?php
require_once '../backend/config.php';

class ReponseModel {
    private $pdo;

    public function __construct() {
        $this->pdo = $GLOBALS['pdo'];
    }

    // Ajouter une réponse
    public function add($idreclamation, $id, $message, $typerep) {
        $date = date('Y-m-d');
        $stmt = $this->pdo->prepare("INSERT INTO reponse (idreclamation, id, message, daterep, typerep) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$idreclamation, $id, $message, $date, $typerep]);
    }

    // Modifier une réponse
    public function update($idreponse, $message, $typerep) {
        $stmt = $this->pdo->prepare("UPDATE reponse SET message = ?, typerep = ? WHERE idreponse = ?");
        return $stmt->execute([$message, $typerep, $idreponse]);
    }

    // Supprimer une réponse
    public function delete($idreponse) {
        $stmt = $this->pdo->prepare("DELETE FROM reponse WHERE idreponse = ?");
        return $stmt->execute([$idreponse]);
    }

    // Lire toutes les réponses
    public function readAll() {
        $stmt = $this->pdo->query("SELECT * FROM reponse ORDER BY daterep DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtenir une réponse par son ID
    public function getByReclamationId($idreclamation) {
        $sql = "SELECT * FROM reponse WHERE idreclamation = ?";
        $stmt = $this->pdo->prepare($sql);  // Corrigé ici pour utiliser $this->pdo
        $stmt->execute([$idreclamation]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
