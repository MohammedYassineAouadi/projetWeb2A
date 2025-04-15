<?php
$host = 'localhost';
$dbname = 'gestion_reclamation';
$user = 'root';
$password = ''; // Default for XAMPP, no password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    // Enable exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
