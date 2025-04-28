<?php
require_once __DIR__ . '/../../../config.php';
require_once __DIR__ . '/../../../Controller/TestC.php';

$testC = new TestC();
$listeTest = $testC->afficherTests();

$score = $_GET['score'] ?? null;
?>
<?php if ($score !== null): ?>
    <div class="alert alert-success">
        ✅ Votre score : <strong><?= $score ?>/3</strong>
    </div>
<?php endif; ?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Lien Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Raleway:wght@400;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Raleway', 'Poppins', sans-serif;
            background-color: #fff3e0;
            color: #FF5722;
        }

        .section-title {
            text-align: center;
            font-size: 36px;
            margin-bottom: 40px;
            color: #ffa726;
            font-weight: 700;
        }

        .card {
            border: none;
            border-radius: 15px;
            background: #fff;
            padding: 25px;
            box-shadow: 0 6px 15px hsla(38, 87.40%, 49.80%, 0.90);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(230, 200, 65, 0.88);
        }

        .card h4 {
            color: hsla(38, 87.40%, 49.80%, 0.90);
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .btn-primary {
            background: linear-gradient(45deg, rgba(241, 220, 26, 0.94), rgb(245, 150, 9));
            border: none;
            color: #fff;
            padding: 12px 25px;
            border-radius: 30px;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 1px;
            transition: background 0.4s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, rgba(241, 220, 26, 0.94), rgb(245, 150, 9));
        }
    </style>

    <title>Nos Tests</title>
</head>

<body>
    <div class="container my-5">
        <!-- Titre -->
        <div class="section-title">
            <h2>Découvrez nos Tests</h2>
        </div>

        <!-- Cartes Tests -->
        <div class="row">
            <?php foreach ($listeTest as $test): ?>
                <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
                    <div class="card m-3 p-3 w-100">
                        <h4><?= htmlspecialchars($test['test_name']) ?></h4>
                        <a href="detailsTest.php?idTest=<?= $test['idTest'] ?>" class="btn btn-primary mt-auto">Découvrez Plus</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>
