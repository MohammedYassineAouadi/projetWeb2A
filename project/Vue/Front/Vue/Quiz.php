<?php
require_once __DIR__ . '/../../../config.php';
require_once __DIR__ . '/../../../Controller/afficherQuiz.php';

$db = config::getConnexion();
$quizC = new QuizController($db);
$listeQuiz = $quizC->afficherQuiz();

$score = isset($_GET['score']) ? intval($_GET['score']) : null;
?>

<?php if ($score !== null): ?>
    <div class="alert alert-success">
        ✅ Votre score : <strong><?= $score ?>/3</strong>
    </div>
<?php endif; ?>

<!-- Affichage des quiz -->
<?php foreach ($listeQuiz as $quiz): ?>
    <div class="card m-3 p-3 border">
        <h4><?= htmlspecialchars($quiz['quiz_name']) ?></h4>
        <a href="detailsQuiz.php?idQuiz=<?= $quiz['idQuiz'] ?>" class="btn btn-primary">Discover More</a>
    </div>
<?php endforeach; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
    <title>Training Studio - Free CSS Template</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/font-awesome.css">
    <link rel="stylesheet" href="../assets/css/templatemo-training-studio.css">
</head>
    
<body>
    <!-- Formulaire du Quiz -->
    <section class="section" id="quiz-form">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="section-heading">
                        <h2>Quiz <em>interactive</em></h2>
                        <p>Répondez aux questions et soumettez votre score.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <form method="POST" action="QuizController.php?action=submitQuiz">
                        <!-- Question 1 -->
                        <label for="questionQ1">Question 1:</label><br>
                        <input type="radio" name="reponseQ1" value="option1"> Option 1<br>
                        <input type="radio" name="reponseQ1" value="option2"> Option 2<br>
                        <input type="radio" name="reponseQ1" value="option3"> Option 3<br>

                        <!-- Question 2 -->
                        <label for="questionQ2">Question 2:</label><br>
                        <input type="radio" name="reponseQ2" value="option1"> Option 1<br>
                        <input type="radio" name="reponseQ2" value="option2"> Option 2<br>
                        <input type="radio" name="reponseQ2" value="option3"> Option 3<br>

                        <!-- Question 3 -->
                        <label for="questionQ3">Question 3:</label><br>
                        <input type="radio" name="reponseQ3" value="option1"> Option 1<br>
                        <input type="radio" name="reponseQ3" value="option2"> Option 2<br>
                        <input type="radio" name="reponseQ3" value="option3"> Option 3<br>

                        <button type="submit" class="btn btn-primary mt-3">Soumettre</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Include footer and other HTML as needed -->

</body>
</html>
