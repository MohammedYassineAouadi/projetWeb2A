<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: connexion.php');
    exit;
}

require_once __DIR__ . '/../Controleur/check_ban.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
    <title>Mon Profil - Startup Academy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="../../assets/front/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../../assets/front/css/font-awesome.css">
    <link rel="stylesheet" href="../../assets/front/css/templatemo-training-studio.css">
    <link rel="stylesheet" href="../css/profil.css"> <!-- Ton CSS spécial Profil -->
</head>
<body>
    <!-- ***** Preloader Start ***** -->
    <div id="js-preloader" class="js-preloader">
        <div class="preloader-inner">
            <span class="dot"></span>
            <div class="dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->

    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <a href="../../index.php" class="logo">
                            <img src="../../assets/front/images/logo.png" alt="Logo" style="vertical-align: middle; height: 40px;">
                            Startup<em> Academy</em>
                        </a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li class="scroll-to-section"><a href="../../index.php#top">Home</a></li>
                            <li class="scroll-to-section"><a href="../../index.php#features">About</a></li>
                            <li class="scroll-to-section"><a href="../../front/offre_emploi/offre_emploi.php">Offres d'Emploi</a></li>
                            <li><a href="../../schedules.html">Schedules</a></li>
                            <li class="has-sub">
                                <a href="javascript:void(0)">Cours</a>
                                <ul class="sub-menu">
                                    <li><a href="../../video.html">Videos</a></li>
                                    <li><a href="../../pdf.html">PDF</a></li>
                                </ul>
                            </li>
                            <li class="has-sub">
                                <a href="javascript:void(0)">exams</a>
                                <ul class="sub-menu">
                                    <li><a href="../../test.html">test</a></li>
                                    <li><a href="../../quiz.html">quiz</a></li>
                                </ul>
                            </li>
                            <li><a href="../../ProjetWeb/index.html">Annonces</a></li>
                            <li class="scroll-to-section"><a href="../../index.php#contact-us">Contact</a></li>
                            <?php if (!isset($_SESSION['user'])): ?>
                                <li class="main-button"><a href="connexion.php">Sign In</a></li>
                            <?php else: ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                        style="display: flex; align-items: center;">
                                        <i class="fa fa-user-circle" style="font-size: 1.5em; margin-right: 5px;"></i>
                                        <?php echo htmlspecialchars($_SESSION['user']['prenom']); ?>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                        <span class="dropdown-item-text"><strong><?php echo htmlspecialchars($_SESSION['user']['prenom'] . ' ' . $_SESSION['user']['nom']); ?></strong></span>
                                        <span class="dropdown-item-text">Role: <?php echo htmlspecialchars($_SESSION['user']['role']); ?></span>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="mon_profil.php"><i class="fa fa-user" style="margin-right: 5px;"></i>Mon Profil</a>
                                        <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                                            <a class="dropdown-item" href="../../backoffice/Vue/dashboard.php"><i class="fa fa-tachometer" style="margin-right: 5px;"></i>Dashboard</a>
                                        <?php endif; ?>
                                        <a class="dropdown-item" href="../logout.php"><i class="fa fa-sign-out" style="margin-right: 5px;"></i>Logout</a>
                                    </div>
                                </li>
                            <?php endif; ?>
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
    <!-- ***** Header Area End ***** -->

    <div class="profile-container" style="margin-top: 120px; margin-bottom: 60px;">
        <div class="profile-card">
            <img src="../images/avatar.png" alt="Photo de profil" class="profile-image">
            <h2><?php echo htmlspecialchars($_SESSION['user']['prenom'] . ' ' . $_SESSION['user']['nom']); ?></h2>
            <p class="profile-role"><?php echo htmlspecialchars($_SESSION['user']['role']); ?></p>
            <div class="profile-contact">
                <p><i class="fa-solid fa-id-badge"></i> ID: <?php echo htmlspecialchars($_SESSION['user']['id']); ?></p>
                <p><i class="fa-solid fa-envelope"></i> <?php echo htmlspecialchars($_SESSION['user']['email']); ?></p>
                <p><i class="fa-solid fa-phone"></i> 
                    <?php 
                    $telephone = isset($_SESSION['user']['telephone']) ? trim($_SESSION['user']['telephone']) : '';
                    echo !empty($telephone) ? htmlspecialchars($telephone) : "Non renseigné";
                    ?>
                </p>
            </div>
            <a href="../logout.php" class="btn-logout">Se déconnecter</a>
        </div>
    </div>

    <!-- ***** Footer Start ***** -->
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

    <!-- jQuery -->
    <script src="../../assets/front/js/jquery-2.1.0.min.js"></script>
    <!-- Bootstrap -->
    <script src="../../assets/front/js/popper.js"></script>
    <script src="../../assets/front/js/bootstrap.min.js"></script>
    <!-- Plugins -->
    <script src="../../assets/front/js/scrollreveal.min.js"></script>
    <script src="../../assets/front/js/waypoints.min.js"></script>
    <script src="../../assets/front/js/jquery.counterup.min.js"></script>
    <script src="../../assets/front/js/imgfix.min.js"></script>
    <script src="../../assets/front/js/mixitup.js"></script>
    <script src="../../assets/front/js/accordions.js"></script>
    <!-- Global Init -->
    <script src="../../assets/front/js/custom.js"></script>
</body>
</html>
