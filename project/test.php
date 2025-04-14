<?php
try {
    new PDO("mysql:host=localhost;dbname=projet", "root", "");
    echo "✅ PDO OK";
} catch (PDOException $e) {
    echo "❌ Erreur : " . $e->getMessage();
}
