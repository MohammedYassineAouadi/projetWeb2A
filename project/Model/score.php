<?php
require_once __DIR__ . '/../config.php';

class Score {
    private $iduser;
    private $idQuiz;
    private $idTest;

    public function __construct($iduser, $idQuiz = null, $idTest = null) {
        $this->iduser = $iduser;
        $this->idQuiz = $idQuiz;
        $this->idTest = $idTest;
    }

    // Getters
    public function getIduser() {
        return $this->iduser;
    }

    public function getIdQuiz() {
        return $this->idQuiz;
    }

    public function getIdTest() {
        return $this->idTest;
    }

    // Setters
    public function setIdQuiz($idQuiz) {
        $this->idQuiz = $idQuiz;
    }

    public function setIdTest($idTest) {
        $this->idTest = $idTest;
    }

    // Ajouter un score dans la table
    public function ajouterScore() {
        $db = config::getConnexion();

        $sql = "INSERT INTO score (iduser, idQuiz, idTest) VALUES (:iduser, :idQuiz, :idTest)";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':iduser', $this->iduser, PDO::PARAM_INT);
        $stmt->bindValue(':idQuiz', $this->idQuiz, PDO::PARAM_INT);
        $stmt->bindValue(':idTest', $this->idTest, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Récupérer tous les scores
    public static function getAllScores() {
        $db = config::getConnexion();
        $sql = "SELECT s.idscore, s.iduser, s.idQuiz, s.idTest, u.prenom, u.nom, q.quiz_name, t.test_name
                FROM score s
                LEFT JOIN utilisateur u ON s.iduser = u.id
                LEFT JOIN quizzes q ON s.idQuiz = q.idQuiz
                LEFT JOIN tests t ON s.idTest = t.idTest";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
