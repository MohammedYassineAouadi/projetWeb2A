<?php
// Ce fichier génère un hash sécurisé pour ton mot de passe
// Tu peux exécuter ce fichier dans ton navigateur local

if (isset($_POST['password'])) {
    $mot_de_passe = $_POST['password'];
    $hash = password_hash($mot_de_passe, PASSWORD_BCRYPT);

    echo "<h3>Voici ton mot de passe sécurisé :</h3>";
    echo "<textarea style='width:100%;height:100px;'>$hash</textarea>";
    echo "<br><a href='generate_password.php'>Générer un autre</a>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Générateur de mot de passe sécurisé</title>
</head>
<body>
    <h2>Entrez votre mot de passe :</h2>
    <form method="post">
        <input type="text" name="password" required>
        <button type="submit">Générer Hash</button>
    </form>
</body>
</html>
