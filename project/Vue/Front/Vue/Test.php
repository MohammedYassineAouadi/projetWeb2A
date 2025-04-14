<?php
require_once __DIR__ . '/../../../config.php';
require_once __DIR__ . '/../../../Controller/TestC.php';

$testC = new TestC();
$listeTest = $testC->afficherTests();
?>




<!DOCTYPE html>
<html lang="en">

  <head>

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
                                    <li><a href="video.html">Videos</a></li>
                                    <li><a href="pdf.html">PDF</a></li>
                                </ul>
                            </li>
                            <li class="has-sub">
                                <a href="javascript:void(0)">exams</a>
                                <ul class="sub-menu">
                                    <li><a href="test.html">test</a></li>
                                    <li><a href="quiz.html">quiz</a></li>
                                </ul>
                            </li>

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

 

    <!-- ***** Features Item Start ***** -->
<section class="section" id="features">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 offset-lg-3">
        <div class="section-heading">
          <h2>TEST <em>option</em></h2>
          <img src="../assets/images/line-dec.png" alt="waves">
          <p>Discover our tests to evaluate your skills and track your progress on Startup Academy.</p>
        </div>
      </div>

      <div class="col-lg-6">
        <ul class="features-items">
          <?php foreach ($listeTest as $test): ?>
          <li class="feature-item">
            <div class="left-icon">
              <img src="../assets/images/test.jpg" alt="test">
            </div>
            <div class="right-content">
              <h4><?= htmlspecialchars($test['test_name']) ?></h4>
              <p>Take this test and check your knowledge.</p>
              <a href="detailsTest.php?idTest=<?= $test['idTest'] ?>" class="text-button">Discover More</a>
            </div>
          </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
</section>
<!-- ***** Features Item End ***** -->
    
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
    <script src="../assets/js/jquery-2.1.0.min.js"></script>

    <!-- Bootstrap -->
    <script src="../assets/js/popper.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>

    <!-- Plugins -->
    <script src="../assets/js/scrollreveal.min.js"></script>
    <script src="../assets/js/waypoints.min.js"></script>
    <script src="../assets/js/jquery.counterup.min.js"></script>
    <script src="../assets/js/imgfix.min.js"></script> 
    <script src="../assets/js/mixitup.js"></script> 
    <script src="../assets/js/accordions.js"></script>
    
    <!-- Global Init -->
    <script src="../assets/js/custom.js"></script>

  </body>
</html>
