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
}
?>

