<?php
session_start();
require 'config.php'; // Fichier de connexion à la base de données

if (isset($_GET['id']) && isset($_GET['cle']) && !empty($_GET['id']) && !empty($_GET['cle'])) {
    
    $getid = $_GET['id'];
    $getcle = $_GET['cle'];
    // $recupUser = 


} else {
    echo 'aucun utilisateur trouvé';
}
?>

