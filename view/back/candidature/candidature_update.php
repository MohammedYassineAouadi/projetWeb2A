<?php
require_once __DIR__ . '/../../../controller/candidature_con.php';

$controller = new CandidatureCon();
$msg = '';
$candidature = null;

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $data = $controller->getOne($id);
    if ($data) {
        $candidature = $data;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['statut'])) {
    $id = intval($_POST['id']);
    $statut = $_POST['statut'];
    $controller->updateStatut($id, $statut);
    header('Location: candidature_list.php?updated=1');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Changer Statut Candidature</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../../../assets/back/styles/core.css">
    <link rel="stylesheet" type="text/css" href="../../../assets/back/styles/icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="../../../assets/back/styles/style.css">
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-left">
            <div class="menu-icon dw dw-menu"></div>
        </div>
        <div class="header-right">
            <div class="user-info-dropdown">
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                        <span class="user-icon">
                            <img src="../../../assets/back/images/photo1.jpg" alt="">
                        </span>
                        <span class="user-name">Admin</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                        <a class="dropdown-item" href="#"><i class="dw dw-user1"></i> Profile</a>
                        <a class="dropdown-item" href="#"><i class="dw dw-logout"></i> Log Out</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Sidebar -->
    <div class="left-side-bar">
        <div class="brand-logo">
            <a href="#">
                <img src="../../../assets/back/images/logoicon.png" alt="" class="dark-logo">
                <img src="../../../assets/back/images/logo.png" alt="" class="light-logo">
            </a>
            <div class="close-sidebar" data-toggle="left-sidebar-close">
                <i class="ion-close-round"></i>
            </div>
        </div>
        <div class="menu-block customscroll">
            <div class="sidebar-menu">
                <ul id="accordion-menu">
                    <li><a href="../offre_emploi/offre_emploi_list.php" class="dropdown-toggle no-arrow"><span class="micon dw dw-list"></span><span class="mtext">Liste des Offres</span></a></li>
                    <li><a href="candidature_list.php" class="dropdown-toggle no-arrow"><span class="micon dw dw-user1"></span><span class="mtext">Liste des Candidatures</span></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="mobile-menu-overlay"></div>
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div class="pd-20 card-box mb-30">
                    <h4 class="text-blue h4">Changer Statut de la Candidature</h4>
                    <?php if (!$candidature): ?>
                        <div class="alert alert-danger">Candidature non trouvée !</div>
                    <?php else: ?>
                    <form method="post" action="">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($candidature['id']) ?>">
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label" for="statut">Statut</label>
                            <div class="col-sm-12 col-md-10">
                                <select class="form-control" name="statut" id="statut" required>
                                    <option value="en attente" <?= $candidature['statut'] === 'en_attente' ? 'selected' : '' ?>>En attente</option>
                                    <option value="acceptee" <?= $candidature['statut'] === 'acceptee' ? 'selected' : '' ?>>Acceptée</option>
                                    <option value="refusee" <?= $candidature['statut'] === 'refusee' ? 'selected' : '' ?>>Refusée</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 col-md-10 offset-md-2">
                                <button class="btn btn-primary" type="submit">Mettre à jour</button>
                                <a href="candidature_list.php" class="btn btn-secondary">Retour à la liste</a>
                            </div>
                        </div>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-wrap pd-20 mb-20 card-box">
        DeskApp - Bootstrap Admin Template By <a href="https://github.com/dropways/deskapp" target="_blank">dropways</a>
    </div>
</body>
</html>
