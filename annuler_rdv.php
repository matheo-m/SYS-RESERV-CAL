<?php
session_start();
require 'config.php';

if (!isset($_SESSION['id']) || !isset($_GET['id'])) {
    header("Location: mes_rdv.php");
    exit();
}

$id_rdv = $_GET['id'];

// Vérifier si le rendez-vous appartient à l'utilisateur
$verifRdv = $bdd->prepare("SELECT * FROM rendez_vous WHERE id = ? AND utilisateur_id = ?");
$verifRdv->execute(array($id_rdv, $_SESSION['id']));

if ($verifRdv->rowCount() > 0) {
    $deleteRdv = $bdd->prepare("DELETE FROM rendez_vous WHERE id = ?");
    $deleteRdv->execute(array($id_rdv));
    header("Location: mes_rdv.php?message=Rendez-vous annulé avec succès");
} else {
    header("Location: mes_rdv.php?message=Accès refusé à ce rendez-vous");
}
exit();
?>