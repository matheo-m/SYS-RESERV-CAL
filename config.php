<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=reservation_system;charset=utf8", "root", ""); // Crée une nouvelle instance de PDO pour se connecter à la base de données
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Définit le mode d'erreur de PDO pour lancer des exceptions
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage()); // Affiche un message d'erreur et arrête le script en cas d'exception PDO
}
?>