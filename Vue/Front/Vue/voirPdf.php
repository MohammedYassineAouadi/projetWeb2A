<?php
// Ajout des en-têtes CORS pour autoriser les requêtes cross-origin
header("Access-Control-Allow-Origin: *");  // Permet toutes les origines, tu peux aussi spécifier un domaine particulier si tu veux
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once "../../../controller/pdfC.php";

session_start();
$db=config::getConnexion();
// Simuler un utilisateur connecté (à remplacer par votre vrai login)
$_SESSION['id'] = 1; // Exemple: utilisateur avec ID 1

$userId = isset($_SESSION['id']) ? $_SESSION['id'] : null;

if (!isset($_GET['id_pdf'])) {

    echo "❌ PDF non trouvé.";
    exit;
}

// Récupérer l'ID
$id_pdf = (int)$_GET['id_pdf'];

// Instancier le contrôleur et récupérer le PDF
$pdfC = new PdfC();
$pdf = $pdfC->getPdfById($id_pdf);
if (!$pdf) {
    echo "PDF introuvable.";
    exit;
}

// Récupérer l'URL du PDF
$pdf_url = $pdf['url'];  // Assure-toi que tu récupères correctement l'URL du PDF

// Vérifier l'URL et l'afficher (pour débogage)

// Vérifier si l'URL du PDF est valide

// Récupérer les vidéos associées à ce PDF

$pdo = config::getConnexion();
$stmt = $pdo->prepare("SELECT * FROM video WHERE id_pdf = :id_pdf");
$stmt->execute(['id_pdf' => $id_pdf]);
$videos = $stmt->fetchAll();

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
<!-- 📌 Utilisation cohérente de la version 2.14.305 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.14.305/pdf.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    
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
        <!-- Titre principal -->
        <div class="row">
        <div class="col-lg-12 text-center">
    <h2 class="pdf-title"><?= htmlspecialchars($pdf['titre']) ?> <small class="pdf-type"><?= htmlspecialchars($pdf['Type']) ?></small></h2>
    <hr class="my-4" />
</div>

        </div>

        <div>
        <div id="pdf-container" style="overflow: auto; height: 100vh;">
    <canvas id="pdf-canvas"></canvas>
    
    <p id="page-status" style="margin-bottom: 10px; font-weight: bold; font-family: Arial;"></p>

</div>

<!-- Barre de progression -->
<div style="width: 100%; background-color: #eee; height: 10px; margin-top: 10px;">
    
    <div id="progress-bar" style="background-color: #4CAF50; height: 100%; width: 0%;"></div>
</div>

<!-- Boutons de navigation -->
<div style="margin-top: 20px;">
    <button id="prev-button">Page Précédente</button>
    <button id="next-button" style="margin-left: 10px;">Page Suivante</button>
    <button id="save-progress">Enregistrer ma progression</button>

</div>

        

        <hr class="my-5" />

        <!-- Section Vidéos -->
        <div class="row">
            <div class="col-lg-12 text-center">
                <h3 class="mb-4">Vidéos Associées</h3>
            </div>
        </div>

        <div class="row">
            <?php foreach ($videos as $video): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <!-- Carte vidéo -->
                    <div class="card shadow-sm" style="border-radius: 10px;">
                    <div class="pdf-thumb" style="display: flex; justify-content: center; align-items: center; height: 220px;">
                            <!-- Image de la vidéo centrée -->
                            <img src="../uploads/video.png" alt="Vidéo" class="card-img-top" 
                                 style="object-fit: cover; width: 70%; height: 100%; border-radius: 10px;">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($video['titre']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($video['description']) ?></p>
                            <p><strong>Durée:</strong> <?= htmlspecialchars($video['duree']) ?> minutes</p>
                            <p><strong>Date ajoutée:</strong> <?= htmlspecialchars($video['date_ajout']) ?></p>

                            <!-- Bouton pour voir la vidéo -->
                            <a href="voir_video.php?id_video=<?= htmlspecialchars($video['id_video']) ?>" class="btn btn-primary mt-3">
                                Voir la vidéo
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Bouton retour -->
        <div class="row mt-4">
            <div class="col-lg-12 text-center">
                <a href="pdf.php" class="btn btn-outline-primary">⬅ Retour à la liste des PDF</a>
            </div>
        </div>
    </div>
</section>
<section class="section" id="contact-us">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-xs-12">
                <div id="map">
                  <iframe src="https://maps.google.com/maps?q=Av.+L%C3%BAcio+Costa,+Rio+de+Janeiro+-+RJ,+Brazil&t=&z=13&ie=UTF8&iwloc=&output=embed" width="100%" height="600px" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-xs-12">
                <div class="contact-form">
                    <form id="contact" action="" method="post">
                      <div class="row">
                        <div class="col-md-6 col-sm-12">
                          <fieldset>
                            <input name="name" type="text" id="name" placeholder="Your Name*" required="">
                          </fieldset>
                        </div>
                        <div class="col-md-6 col-sm-12">
                          <fieldset>
                            <input name="email" type="text" id="email" pattern="[^ @]*@[^ @]*" placeholder="Your Email*" required="">
                          </fieldset>
                        </div>
                        <div class="col-md-12 col-sm-12">
                          <fieldset>
                            <input name="subject" type="text" id="subject" placeholder="Subject">
                          </fieldset>
                        </div>
                        <div class="col-lg-12">
                          <fieldset>
                            <textarea name="message" rows="6" id="message" placeholder="Message" required=""></textarea>
                          </fieldset>
                        </div>
                        <div class="col-lg-12">
                          <fieldset>
                            <button type="submit" id="form-submit" class="main-button">Send Message</button>
                          </fieldset>
                        </div>
                      </div>
                    </form>
                </div>
            </div>
        </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.14.305/pdf.min.js"></script>
<script>
let pdfDoc = null;
let currentPage = 1;
let totalPages = 100;
let maxPageSeen = 1;
let pageEnterTime = Date.now();

const canvas = document.getElementById('pdf-canvas');
const context = canvas.getContext('2d');
const progressBar = document.getElementById('progress-bar');

// Fonction pour réinitialiser le visionneur
function resetPdfViewer() {
    pdfDoc = null;
    currentPage = 1;
    maxPageSeen = 1;
    progressBar.style.width = '0%';
    canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height); // Clear the canvas
}

// Fonction pour charger un nouveau PDF
function loadNewPdf(pdfUrl) {
    resetPdfViewer();  // Réinitialiser les données du précédent PDF
    console.log("Chargement du PDF depuis : ", pdfUrl);

    const fileName = getBasename(pdfUrl);
    const proxyUrl = "http://localhost/project/Vue/Front/Vue/loadpdf.php?file=" + encodeURIComponent(fileName);

    fetch(proxyUrl)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Erreur de téléchargement du PDF : ${response.statusText}`);
            }
            return response.blob();
        })
        .then(blob => {
            const pdfBlobUrl = URL.createObjectURL(blob);

            pdfjsLib.getDocument(pdfBlobUrl).promise.then(function (pdf) {
                pdfDoc = pdf;
                totalPages = pdf.numPages;
                console.log(`Total des pages du PDF : ${totalPages}`);
                
                // Récupérer la dernière page vue et la progression depuis localStorage
                const savedPage = localStorage.getItem('lastPage');
                const savedProgress = localStorage.getItem('progress');

                currentPage = savedPage ? parseInt(savedPage) : 1; // page courante sauvegardée
                const progress = savedProgress ? parseFloat(savedProgress) : 0; // progression sauvegardée

                // Récupérer la dernière page vue et ajuster la barre de progression
                if (progress > 0) {
                    progressBar.style.width = `${progress}%`;
                }
                
                renderPage(currentPage); // Rendre la page
            }).catch(error => {
                console.error("❌ Erreur lors du rendu du PDF :", error);
            });
        })
        .catch(error => {
            console.error("❌ Erreur lors de la récupération du fichier PDF :", error);
        });
}

// Fonction pour afficher une page
function renderPage(pageNum) {
    pageEnterTime = Date.now(); // temps d'entrée dans la nouvelle page

    pdfDoc.getPage(pageNum).then(function (page) {
        const scale = 1.5;
        const viewport = page.getViewport({ scale: scale });

        canvas.height = viewport.height;
        canvas.width = viewport.width;

        const renderContext = {
            canvasContext: context,
            viewport: viewport
        };

        page.render(renderContext).promise.then(() => {
            console.log(`Page ${pageNum} rendue avec succès`);

            // Mettre à jour la barre de progression
            if (pageNum > maxPageSeen) {
                maxPageSeen = pageNum;
            }

            const progress = (maxPageSeen / totalPages) * 100;
            progressBar.style.width = `${progress}%`;

            // Sauvegarder la page actuelle et la progression dans localStorage
            localStorage.setItem('lastPage', pageNum);
            localStorage.setItem('progress', progress);
        }).catch(error => {
            console.error("❌ Erreur lors du rendu de la page :", error);
        });
    }).catch(error => {
        console.error("❌ Erreur lors de la récupération de la page :", error);
    });
}

// Extraire le nom du fichier
function getBasename(path) {
    return path.substring(path.lastIndexOf('/') + 1);
}

// Fonction pour charger un PDF à partir de l'URL
const urlParams = new URLSearchParams(window.location.search);
const pdfUrl = urlParams.get("url");

if (pdfUrl) {
    loadNewPdf(pdfUrl); // Charger le PDF à partir de l'URL spécifiée
}

// Gestion du bouton Page Suivante
document.getElementById('next-button').addEventListener('click', () => {
    const timeSpent = Date.now() - pageEnterTime;

    if (currentPage < totalPages) {
        currentPage++;
        if (currentPage > maxPageSeen) {
            maxPageSeen = currentPage;
        }
        renderPage(currentPage);
    }
});

// Gestion du bouton Page Précédente
document.getElementById('prev-button').addEventListener('click', () => {
    const timeSpent = Date.now() - pageEnterTime;

    if (currentPage > 1) {
        currentPage--;
        // On ne diminue la progression que si le temps passé est très court (< 1 seconde)
        if (timeSpent < 1000 && currentPage < maxPageSeen) {
            maxPageSeen = currentPage;
        }
        renderPage(currentPage);
    }
});
document.addEventListener('DOMContentLoaded', function() {
    const saveButton = document.getElementById('save-progress');
    
    if (saveButton) {
        saveButton.addEventListener('click', () => {
            // Calcul du pourcentage de progression
            const progress = (maxPageSeen / totalPages) * 100;
            
            // Récupérer l'ID du PDF
            const urlParams = new URLSearchParams(window.location.search);
            const pdfUrl = urlParams.get("id_pdf");
            const currentPdfId = getBasename(pdfUrl);  // Vous devez vous assurer que pdfUrl est bien défini

            // Récupérer l'ID utilisateur depuis la session PHP
            const userId = <?php echo json_encode($userId); ?>;

            if (!userId) {
                alert("Utilisateur non connecté !");
                return;
            }

            // Créer l'objet de données à envoyer
            const data = {
                id: userId,
                id_pdf: currentPdfId,
                pages_lues: currentPage,
                total_pages: totalPages,
                pourcentage: progress
            };

            console.log("URL de la requête:", 'progression.php');

            fetch('progression.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'  // En-tête correct pour JSON
                },
                body: JSON.stringify(data)  // Convertir l'objet en JSON
            })
            .then(response => response.text())  // Récupérer la réponse en texte brut
            .then(text => {
                console.log("Réponse brute du serveur:", text);  // Affiche la réponse brute pour voir ce qui est renvoyé par le serveur

                try {
                    const data = JSON.parse(text);  // Essayer de convertir le texte en JSON
                    if (data.success) {
                        console.log('Progression enregistrée avec succès');
                    } else {
                        console.error('Erreur lors de l\'enregistrement de la progression', data);
                    }
                } catch (error) {
                    console.error('Erreur lors de la conversion en JSON:', error);
                    console.error('Réponse brute:', text);  // Afficher la réponse brute en cas d'erreur
                }
            })
            .catch(error => {
                console.error('Erreur de connexion au serveur:', error);
            });
        });
    }
});

</script>


</body>
</html>
