<?php
$maxTries = 10;
while ($maxTries > 0) {
    try {
        $bdd = new PDO("mysql:host=db;port=3306;dbname=reservation;charset=utf8", "root", "");
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        break; // connexion réussie, on sort
    } catch (PDOException $e) {
        $maxTries--;
        sleep(2); // attend 2 secondes
    }
}

if ($maxTries <= 0) {
    die("Erreur de connexion à la base de données après plusieurs tentatives.");
}
?>
