<?php
session_start();
require 'config.php'; // Connexion à la base de données

if (isset($_POST['valider'])) {
    if (isset($_POST['email'], $_POST['password']) && !empty($_POST['email']) && !empty($_POST['password'])) {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

        $recupUser = $bdd->prepare('SELECT * FROM utilisateurs WHERE email = ?');
        $recupUser->execute(array($email));

        if ($recupUser->rowCount() > 0) {
            $userInfo = $recupUser->fetch();

            // Vérification du mot de passe
            if (password_verify($_POST['password'], $userInfo['password'])) {
                session_regenerate_id(true); // Sécurise la session

                $_SESSION['id'] = $userInfo['id'];
                $_SESSION['email'] = $userInfo['email'];
                $_SESSION['nom'] = $userInfo['nom'];
                $_SESSION['prenom'] = $userInfo['prenom'];

                $_SESSION['date_naissance'] = $userInfo['date_naissance'];
                $_SESSION['adresse'] = $userInfo['adresse'];
                $_SESSION['telephone'] = $userInfo['telephone'];


                header('Location: profil.php'); // Redirige vers le profil
                exit;
            } else {
                $error = "Mot de passe incorrect.";
            }
        } else {
            $error = "Cet email n'existe pas.";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Connexion</h2>
        <?php if (isset($error))
            echo '<div class="alert alert-danger">' . $error . '</div>'; ?>
        <form action="" method="POST">
            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <input type="submit" class="btn btn-primary" name="valider" value="Se connecter">
        </form>

    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>