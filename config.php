<?php
try {
    $bdd = new PDO("mysql:host=db;port=3306;dbname=reservation;charset=utf8", "root", ""); // utilise 'db' comme hôte

    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
