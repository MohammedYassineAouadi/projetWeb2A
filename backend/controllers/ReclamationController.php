<?php
require_once __DIR__ . '/../config.php';

class ReclamationController
{
    public static function addReclamation($contenu, $type)
    {
        global $pdo;

        $date = date('Y-m-d');
        $statut = 'en attente';

        $sql = "INSERT INTO reclamation (contenu, statut, datereclamation, type)
                VALUES (:contenu, :statut, :datereclamation, :type)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':contenu' => $contenu,
            ':statut' => $statut,
            ':datereclamation' => $date,
            ':type' => $type
        ]);
    }

    public static function getAllReclamations()
    {
        global $pdo;

        $stmt = $pdo->query("SELECT * FROM reclamation ORDER BY datereclamation DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
