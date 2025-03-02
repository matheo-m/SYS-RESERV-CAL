<?php
session_start();
require 'config.php'; // Fichier de connexion à la base de données

if (isset($_GET['id']) && isset($_GET['cle']) && !empty($_GET['id']) && !empty($_GET['cle'])) {
    
    $getid = $_GET['id'];
    $getcle = $_GET['cle'];
    $recupUser = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ? AND cle = ?');
    $recupUser->execute(array($getid, $getcle));
    if ($recupUser->rowCount() > 0) {
        $userInfo   = $recupUser->fetch();
        if ($userInfo['confirme'] != 1) {
            $updateConfirmation = $bdd->prepare('UPDATE utilisateurs SET confirme = ? WHERE id = ?');
            $updateConfirmation->execute(array(1, $getid));
            $_SESSION['cle'] = $getcle;
            header('Location: index.php');
        } else {
            $_SESSION['cle'] = $getcle;
            header('Location: index.php');
        }
    } else {
        echo 'Votre clé ou identifiant est invalide';
    } 


} else {
    echo 'aucun utilisateur trouvé';
    echo 'Clé: ' . htmlspecialchars($_GET['cle']) . '<br>';
    echo 'ID: ' . htmlspecialchars($_GET['id']);
}
?>

