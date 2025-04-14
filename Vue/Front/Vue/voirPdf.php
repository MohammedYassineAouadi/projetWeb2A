<?php
require_once "../../../controller/pdfC.php";

if (!isset($_GET['id_pdf'])) {
    echo "PDF non trouvé.";
    exit;
}

$id_pdf = (int)$_GET['id_pdf'];
$pdfC = new PdfC();
$pdf = $pdfC->getPdfById($id_pdf);

if (!$pdf) {
    echo "PDF introuvable.";
    exit;
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

<!-- Ton header ici -->
<br>  </br>
<br>  </br>
<br>  </br>

<section class="section" id="pdf-view">
    <div class="container">
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($pdf['titre']) ?></title>
    <br>  </br>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/your-site-style.css">
        <h2><?= htmlspecialchars($pdf['titre']) ?> <small>(<?= htmlspecialchars($pdf['Type']) ?>)</small></h2>
        <br>  </br>
        <div style="border: 1px solid #ccc; margin-top: 20px;">
            <embed src="<?= htmlspecialchars($pdf['url']) ?>" type="application/pdf" width="100%" height="500px" />
        </div>
        <a href="pdf.php" class="btn btn-outline-primary mt-3">⬅ Retour à la liste</a>
    </div>
</section>

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

</body>
</html>
