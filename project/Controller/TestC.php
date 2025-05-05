<?php
require_once __DIR__.'../../config.php';  // Assure-toi que le chemin est correct
require_once __DIR__.'../../Model/Test.php';



class TestC
{
    private $db;
private $conn;
    public function __construct()
    {
        $this->db = config::getConnexion(); // Connexion à la base de données
    }

    public function ajouterTest(Test $test) {
        $sql = "INSERT INTO tests 
            (test_name, questionT1, reponseT1, reponse_correcteT1,
             questionT2, repT2, rep_correcteT2,
             questionT3, reponT3, repon_correcteT3)
            VALUES 
            (:test_name, :questionT1, :reponseT1, :reponse_correcteT1,
             :questionT2, :repT2, :rep_correcteT2,
             :questionT3, :reponT3, :repon_correcteT3)";
    
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
    
            $query->bindValue(':test_name', $test->getTestName());
            $query->bindValue(':questionT1', $test->getQuestionT1());
            $query->bindValue(':reponseT1', $test->getReponseT1());
            $query->bindValue(':reponse_correcteT1', $test->getReponseCorrecteT1());
    
            $query->bindValue(':questionT2', $test->getQuestionT2());
            $query->bindValue(':repT2', $test->getRepT2());
            $query->bindValue(':rep_correcteT2', $test->getRepCorrecteT2());
    
            $query->bindValue(':questionT3', $test->getQuestionT3());
            $query->bindValue(':reponT3', $test->getReponT3());
            $query->bindValue(':repon_correcteT3', $test->getReponCorrecteT3());
    
            $query->execute();
        } catch (PDOException $e) {
            echo "Erreur: " . $e->getMessage();
        }
    }
    // Méthode pour afficher tous les tests
// ✅ Fonction pour afficher les tests
public function afficherTests() {
    $sql = "SELECT * FROM tests";
    $stmt = $this->db->query($sql); // <- ici le changement
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function deleteTest($idTest) {
         // Préparer la requête de suppression
         $sql = "DELETE FROM tests WHERE idTest = :idTest";
         $db = config::getConnexion();
         $stmt = $db->prepare($sql);
         
         // Lier la valeur du paramètre :id à la variable $id
         $stmt->bindValue(':idTest', $idTest, PDO::PARAM_INT);
         try {
             $stmt->execute();
         } catch (Exception $e) {
             die('Erreur: ' . $e->getMessage());
         }
     }


public function modifierTest($data) {
    $sql = "UPDATE tests SET 
                test_name = :test_name,
                questionT1 = :questionT1,
                reponseT1 = :reponseT1,
                reponse_correcteT1 = :reponse_correcteT1,
                questionT2 = :questionT2,
                repT2 = :repT2,
                rep_correcteT2 = :rep_correcteT2,
                questionT3 = :questionT3,
                reponT3 = :reponT3,
                repon_correcteT3 = :repon_correcteT3
            WHERE idTest = :idTest";

    $db = config::getConnexion();
    try {
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':idTest', $data['idTest']);
        $stmt->bindValue(':test_name', $data['test_name']);
        $stmt->bindValue(':questionT1', $data['questionT1']);
        $stmt->bindValue(':reponseT1', $data['reponseT1']);
        $stmt->bindValue(':reponse_correcteT1', $data['reponse_correcteT1']);
        $stmt->bindValue(':questionT2', $data['questionT2']);
        $stmt->bindValue(':repT2', $data['repT2']);
        $stmt->bindValue(':rep_correcteT2', $data['rep_correcteT2']);
        $stmt->bindValue(':questionT3', $data['questionT3']);
        $stmt->bindValue(':reponT3', $data['reponT3']);
        $stmt->bindValue(':repon_correcteT3', $data['repon_correcteT3']);

        $stmt->execute();
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}

public function getTestById($idTest) {
    $sql = "SELECT * FROM tests WHERE idTest = :idTest";
    $db = config::getConnexion();

    try {
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':idTest', $idTest, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
public function traiterQuiz($iduser, $idTest) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $scoreTest = 0;

        // Récupérer les bonnes réponses du quiz
        $sql = "SELECT reponse_correcteT1, reponse_correcteT2, reponse_correcteT3 FROM tests WHERE idTest = :idTest";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idTest', $idQuiz, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) return "Test non trouvé.";

        if (isset($_POST['repQ1']) && $_POST['repQ1'] == $result['reponse_correcteT1']) $scoreTest++;
        if (isset($_POST['repQ2']) && $_POST['repQ2'] == $result['rep_correcteT2']) $scoreTest++;
        if (isset($_POST['repQ3']) && $_POST['repQ3'] == $result['repon_correcteT3']) $scoreTest++;

        $this->enregistrerScore($iduser, $scoreTest);

        return $scoreTest;
    }
}
public function enregistrerScore($iduser, $resultatQuiz = null, $resultatTest = null) {
    $sql = "INSERT INTO score (iduser, resultatQuiz, resultatTest) VALUES (:iduser, :resultatQuiz, :resultatTest)";
    
    try {
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':iduser', $iduser, PDO::PARAM_INT);
        $stmt->bindValue(':resultatQuiz', $resultatQuiz, PDO::PARAM_INT);
        $stmt->bindValue(':resultatTest', $resultatTest, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
public function getPdfById($id)
{
    $sql = "SELECT * FROM tests WHERE idTest = :id";
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


