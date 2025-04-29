<?php
class ReclamationModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function addReclamation($contenu, $type, $date) {
        $stmt = $this->pdo->prepare("INSERT INTO reclamation (contenu, type, datereclamation) VALUES (?, ?, ?)");
        return $stmt->execute([$contenu, $type, $date]);
    }

    public function getAllReclamations() {
        $stmt = $this->pdo->query("SELECT * FROM reclamation ORDER BY datereclamation DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteReclamation($id) {
        $stmt = $this->pdo->prepare("DELETE FROM reclamation WHERE idreclamation = ?");
        return $stmt->execute([$id]);
    }

    public function updateReclamation($id, $contenu, $type, $statut) {
        $stmt = $this->pdo->prepare("UPDATE reclamation SET contenu = ?, type = ?, statut = ? WHERE idreclamation = ?");
        return $stmt->execute([$contenu, $type, $statut, $id]);
    }

    public function searchReclamations($query) {
        $stmt = $this->pdo->prepare("SELECT * FROM reclamation WHERE contenu LIKE ?");
        $stmt->execute(["%$query%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function sortReclamations($by) {
        $orderBy = $by === 'alphabetique' ? 'contenu ASC' : 'datereclamation DESC';
        $stmt = $this->pdo->query("SELECT * FROM reclamation ORDER BY $orderBy");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
