<?php
require_once(__DIR__ . "/../../../config.php");

if (!isset($_GET['id_video'])) {
    echo "Aucune vidéo sélectionnée.";
    exit;
}

$id_video = $_GET['id_video'];

// Connexion à la base
$pdo = config::getConnexion();

// Récupérer les infos de la vidéo
$stmt = $pdo->prepare("SELECT * FROM video WHERE id_video = :id_video");
$stmt->execute(['id_video' => $id_video]);
$video = $stmt->fetch();

if (!$video) {
    echo "Vidéo introuvable.";
    exit;
}

// Vérifie si c’est une vidéo YouTube
$isYouTube = false;
$videoId = null;

if (strpos($video['url'], 'youtube.com') !== false || strpos($video['url'], 'youtu.be') !== false) {
    // Extraire l’ID de la vidéo YouTube
    if (strpos($video['url'], 'watch?v=') !== false) {
        parse_str(parse_url($video['url'], PHP_URL_QUERY), $ytParams);
        $videoId = $ytParams['v'] ?? null;
    } else {
        // lien court youtu.be
        $path = parse_url($video['url'], PHP_URL_PATH);
        $videoId = ltrim($path, '/');
    }
    $isYouTube = true;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($video['titre']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">

    <title>Training Studio - Free CSS Template</title>
<!--

TemplateMo 548 Training Studio

https://templatemo.com/tm-548-training-studio

-->
    <!-- Additional CSS Files -->
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="../assets/css/font-awesome.css">

    <link rel="stylesheet" href="../assets/css/templatemo-training-studio.css">
</head>
<body class="bg-light">
<header class="header-area header-sticky background-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <a href="index.html" class="logo"> Startup<em> Academy</em></a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li class="scroll-to-section">
                                <a href="index.html" class="active" style="color: rgba(0,123,255,.25) ;">Home</a>
                            </li>
                            <li class="scroll-to-section">
                                <a href="classes.html" style="color: rgba(0,123,255,.25);">Classes</a>
                            </li>
                            <li class="scroll-to-section">
                                <a href="schedules.html" style="color: rgba(0,123,255,.25);">Schedules</a>
                            </li>
                            <li class="has-sub">
                                <a href="javascript:void(0)">Cours</a>
                                <ul class="sub-menu">
                                    <li><a href="pdf.php">Videos</a></li>
                                    <li><a href="pdf.php">PDF</a></li>
                                </ul>
                            </li>
                            <li><a href="Test.html">Test</a></li>

                            <li class="scroll-to-section">
                                <a href="#contact-us" style="color: rgba(0,123,255,.25);">Contact</a>
                            </li>
                            <li class="main-button">
                                <a href="#" >Sign Up</a>
                            </li>
                        </ul>
                                
                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                        <!-- ***** Menu End ***** -->
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <div class="container py-5">
        <h2 class="mb-4"><?= htmlspecialchars($video['titre']) ?></h2>

        <?php if ($isYouTube && $videoId): ?>
            <div class="ratio ratio-16x9 mb-4">
                <iframe src="https://www.youtube.com/embed/<?= htmlspecialchars($videoId) ?>" 
                        title="YouTube video player"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                </iframe>
            </div>
        <?php else: ?>
            <video width="100%" height="400" controls class="mb-4">
                <source src="/project/Vue/Front/uploadsVideo/<?= htmlspecialchars($video['url']) ?>" type="video/mp4">
                Votre navigateur ne supporte pas la lecture de vidéos.
            </video>
        <?php endif; ?>

        <p><strong>Description :</strong> <?= htmlspecialchars($video['description']) ?></p>
        <p><strong>Durée :</strong> <?= htmlspecialchars($video['duree']) ?> minutes</p>
        <p><strong>Date_ajout :</strong> <?= htmlspecialchars($video['date_ajout']) ?></p>

        <a href="pdf.php" class="btn btn-secondary mt-3">← Retour</a>
    </div>
</body>
<footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; 2020 Training Studio
                    
                    - Designed by <a rel="nofollow" href="https://templatemo.com" class="tm-text-link" target="_parent">TemplateMo</a></p>
                    
                    <!-- You shall support us a little via PayPal to info@templatemo.com -->
                    
                </div>
            </div>
        </div>
    </footer>
</html>
