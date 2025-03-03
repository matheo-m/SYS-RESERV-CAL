<?php
session_start();
require 'config.php'; // Connexion à la base de données

if (isset($_GET['id']) && isset($_GET['cle']) && !empty($_GET['id']) && !empty($_GET['cle'])) {
    
    $getid = (int) $_GET['id'];
    $getcle = (int) $_GET['cle'];

    $recupUser = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ? AND cle = ?');
    $recupUser->execute(array($getid, $getcle));

    if ($recupUser->rowCount() > 0) {
        $user_info = $recupUser->fetch();
        if ($user_info['confirme'] == 0) {
            $updateConfirmation = $bdd->prepare('UPDATE utilisateurs SET confirme = 1 WHERE id = ? AND cle = ?');
            $updateConfirmation->execute(array($getid, $getcle));

            echo "Votre compte a été activé avec succès.";
            header('Location: connexion.php?message=compte_active');
            exit();
        } else {
            echo "Ce compte est déjà activé.";
            header('Location: connexion.php');
            exit();
        }
    } else {
        echo "Votre clé ou identifiant est invalide.";
    }
} else {
    echo "Aucun utilisateur trouvé.";
}
?>