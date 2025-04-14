<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../Model/Quiz.php';

class QuizC {
    public function ajouterQuiz(Quiz $quiz) {
        $sql = "INSERT INTO quizzes 
            (quiz_name, questionQ1, option1, option2, option3, correct_option1,
             questionQ2, op1, op2, op3, correct_op2,
             questionQ3, opt1, opt2, opt3, correct_opt3, id_video)
            VALUES 
            (:quiz_name, :questionQ1, :option1, :option2, :option3, :correct_option1,
             :questionQ2, :op1, :op2, :op3, :correct_op2,
             :questionQ3, :opt1, :opt2, :opt3, :correct_opt3, :id_video)";

        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);

            $query->bindValue(':quiz_name', $quiz->getQuizName());
            $query->bindValue(':questionQ1', $quiz->getQuestionQ1());
            $query->bindValue(':option1', $quiz->getOption1());
            $query->bindValue(':option2', $quiz->getOption2());
            $query->bindValue(':option3', $quiz->getOption3());
            $query->bindValue(':correct_option1', $quiz->getCorrectOption1());

            $query->bindValue(':questionQ2', $quiz->getQuestionQ2());
            $query->bindValue(':op1', $quiz->getOp1());
            $query->bindValue(':op2', $quiz->getOp2());
            $query->bindValue(':op3', $quiz->getOp3());
            $query->bindValue(':correct_op2', $quiz->getCorrectOp2());

            $query->bindValue(':questionQ3', $quiz->getQuestionQ3());
            $query->bindValue(':opt1', $quiz->getOpt1());
            $query->bindValue(':opt2', $quiz->getOpt2());
            $query->bindValue(':opt3', $quiz->getOpt3());
            $query->bindValue(':correct_opt3', $quiz->getCorrectOpt3());

            $query->bindValue(':id_video', $quiz->getIdVideo());

            $query->execute();
        } catch (PDOException $e) {
            echo "Erreur: " . $e->getMessage();
        }
    }
    public function deleteQuiz($idQuiz) {
        // Préparer la requête de suppression
        $sql = "DELETE FROM quizzes WHERE idQuiz = :idQuiz";
        $db = config::getConnexion();
        $stmt = $db->prepare($sql);
        
        // Lier la valeur du paramètre :id à la variable $id
        $stmt->bindValue(':idQuiz', $idQuiz, PDO::PARAM_INT);
        try {
            $stmt->execute();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
    public function modifierQuiz($data) {
        $sql = "UPDATE quizzes SET 
                   
                    quiz_name = :quiz_name,
                    questionQ1 = :questionQ1,
                    option1 = :option1,
                    option2 = :option2,
                    option3 = :option3,
                    correct_option1 = :correct_option1,
                    questionQ2 = :questionQ2,
                    op1 = :op1,
                    op2 = :op2,
                    op3 = :op3,
                    correct_op2 = :correct_op2,
                    questionQ3 = :questionQ3,
                    opt1 = :opt1,
                    opt2 = :opt2,
                    opt3 = :opt3,
                    correct_opt3 = :correct_opt3
                WHERE idQuiz = :idQuiz";
            $db = config::getConnexion();

        $stmt = $db->prepare($sql);
    
        $stmt->bindValue(':idQuiz', $data['idQuiz']);
        
        $stmt->bindValue(':quiz_name', $data['quiz_name']);
        $stmt->bindValue(':questionQ1', $data['questionQ1']);
        $stmt->bindValue(':option1', $data['option1']);
        $stmt->bindValue(':option2', $data['option2']);
        $stmt->bindValue(':option3', $data['option3']);
        $stmt->bindValue(':correct_option1', $data['correct_option1']);
        $stmt->bindValue(':questionQ2', $data['questionQ2']);
        $stmt->bindValue(':op1', $data['op1']);
        $stmt->bindValue(':op2', $data['op2']);
        $stmt->bindValue(':op3', $data['op3']);
        $stmt->bindValue(':correct_op2', $data['correct_op2']);
        $stmt->bindValue(':questionQ3', $data['questionQ3']);
        $stmt->bindValue(':opt1', $data['opt1']);
        $stmt->bindValue(':opt2', $data['opt2']);
        $stmt->bindValue(':opt3', $data['opt3']);
        $stmt->bindValue(':correct_opt3', $data['correct_opt3']);
    
        $stmt->execute();
    }
    public function getQuizById($id)
{
    $sql = "SELECT * FROM quizzes WHERE idQuiz = :idQuiz";  // Assure-toi que la colonne est 'idQuiz' dans ta base
    $db = config::getConnexion();
    try {
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':idQuiz', $id);  // Binder l'ID reçu
        $stmt->execute();

    return $stmt->fetch();
    }
    catch (Exception $e) {
        die('Erreur: ' . $e->getMessage());
    }
      // Retourne le quiz correspondant
}

    
}
?>

