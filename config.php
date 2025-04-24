<?php
try {
    $bdd = new PDO("mysql:host=localhost;port=3306;dbname=reservation_system;charset=utf8", "root", ""); // Crée une nouvelle instance de PDO pour se connecter à la base de données

    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Définit le mode d'erreur de PDO pour lancer des exceptions
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage()); // Affiche un message d'erreur et arrête le script en cas d'exception PDO
}
?>