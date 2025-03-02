<?php
session_start();
require 'config.php';

if (!isset($_SESSION['id'])) {
    header("Location: connexion.php");
    exit;
}

if (isset($_POST['supprimer_compte'])) {
    $userId = $_SESSION['id'];

    // Suppression des rendez-vous liés à l'utilisateur
    $deleteRdv = $bdd->prepare("DELETE FROM rendez_vous WHERE utilisateur_id = ?");
    $deleteRdv->execute(array($userId));

    // Suppression de l'utilisateur
    $deleteUser = $bdd->prepare("DELETE FROM utilisateurs WHERE id = ?");
    $deleteUser->execute(array($userId));

    // Déconnexion de l'utilisateur après suppression
    session_unset();
    session_destroy();

    // Redirection vers la page d'inscription avec un message
    header("Location: inscription.php?message=compte_supprime");
    exit;
}
?>
