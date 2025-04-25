<?php

class Test {
    private $test_name;
    private $questionT1;
    private $reponseT1;
    private $reponse_correcteT1;

    private $questionT2;
    private $repT2;
    private $rep_correcteT2;

    private $questionT3;
    private $reponT3;
    private $repon_correcteT3;

    private $idTest;

    // Constructeur
    public function __construct(
        $test_name, $questionT1, $reponseT1, $reponse_correcteT1,
        $questionT2, $repT2, $rep_correcteT2,
        $questionT3, $reponT3, $repon_correcteT3, $idTest
    ) {
        $this->test_name = $test_name;
        $this->questionT1 = $questionT1;
        $this->reponseT1 = $reponseT1;
        $this->reponse_correcteT1 = $reponse_correcteT1;

        $this->questionT2 = $questionT2;
        $this->repT2 = $repT2;
        $this->rep_correcteT2 = $rep_correcteT2;

        $this->questionT3 = $questionT3;
        $this->reponT3 = $reponT3;
        $this->repon_correcteT3 = $repon_correcteT3;

        $this->idTest = $idTest; // Ajout de l'idTest
    }

    // Getters
    public function getTestName() { return $this->test_name; }

    public function getQuestionT1() { return $this->questionT1; }
    public function getReponseT1() { return $this->reponseT1; }
    public function getReponseCorrecteT1() { return $this->reponse_correcteT1; }

    public function getQuestionT2() { return $this->questionT2; }
    public function getRepT2() { return $this->repT2; }
    public function getRepCorrecteT2() { return $this->rep_correcteT2; }

    public function getQuestionT3() { return $this->questionT3; }
    public function getReponT3() { return $this->reponT3; }
    public function getReponCorrecteT3() { return $this->repon_correcteT3; }

    public function getIdTest() { return $this->idTest; }

    // Setters
    public function setTestName($test_name) { $this->test_name = $test_name; }

    public function setQuestionT1($questionT1) { $this->questionT1 = $questionT1; }
    public function setReponseT1($reponseT1) { $this->reponseT1 = $reponseT1; }
    public function setReponseCorrecteT1($reponse_correcteT1) { $this->reponse_correcteT1 = $reponse_correcteT1; }

    public function setQuestionT2($questionT2) { $this->questionT2 = $questionT2; }
    public function setRepT2($repT2) { $this->repT2 = $repT2; }
    public function setRepCorrecteT2($rep_correcteT2) { $this->rep_correcteT2 = $rep_correcteT2; }

    public function setQuestionT3($questionT3) { $this->questionT3 = $questionT3; }
    public function setReponT3($reponT3) { $this->reponT3 = $reponT3; }
    public function setReponCorrecteT3($repon_correcteT3) { $this->repon_correcteT3 = $repon_correcteT3; }

    public function setIdTest($idTest) { $this->idTest = $idTest; }
}

?>
