<?php
require_once __DIR__ . '/../config.php'; // ✅ Chemin corrigé
require_once __DIR__ . '/../Model/Quiz.php';

class QuizController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function afficherQuiz() {
        $sql = "SELECT * FROM quizzes";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

