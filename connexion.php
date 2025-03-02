<?php
session_start();
require 'config.php'; // Fichier de connexion à la base de données

    if(isset($_POST['valider'])){
        if(!empty($_POST['email'])){
            $recupUser = $bdd-> prepare('SELECT * FROM utilisateurs WHERE email = ?');
            $recupUser->execute(array($_POST['email']));
            if($recupUser->rowCount() > 0){
                $userInfo = $recupUser->fetch();
                header('Location: verif.php?id'.$userInfo['id'].'&cle='.$userInfo['cle']);
            }else{
                echo "Cet email n'existe pas";
            }
        }else{
            echo "Veuillez remplir tous les champs";
        }

    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <form action="" method="POST">
        <input type="email" name="email">
        <br>
        <input type="submit" name="valider">

    </form>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html></html>