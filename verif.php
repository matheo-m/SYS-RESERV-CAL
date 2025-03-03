<?php
session_start();
require 'config.php'; // Fichier de connexion à la base de données

if (isset($_GET['id']) && isset($_GET['cle']) && !empty($_GET['id']) && !empty($_GET['cle'])) {
    
    $getid = $_GET['id'];
    $getcle = $_GET['cle'];
    $recupUser = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ? AND cle = ?');
    $recupUser->execute(array($getid, $getcle));
    if ($recupUser->rowCount() > 0) {
        $user_info = $recupUser->fetch();
        if ($user_info['confirme'] == 0) {
            $updateConfirmation = $bdd->prepare('UPDATE utilisateurs SET confirme = 1 WHERE id = ? AND cle = ?');
            $updateConfirmation->execute(array($getid, $getcle));
            $_SESSION['cle'] = $getcle;
            echo "Votre compte a été activé avec succès.";
            header('Location: index.php');
            exit();
        } else {
            echo "Ce compte est déjà activé.";
            header('Location: index.php');
            exit();
        }
    } else {
        echo "Votre clé ou identifiant est invalide.";
    }


} else {
    echo 'aucun utilisateur trouvé';
    echo 'Clé: ' . htmlspecialchars($_GET['cle']) . '<br>';
    echo 'ID: ' . htmlspecialchars($_GET['id']);
}
?>