<?php
// session_start();
require 'config.php'; // Connexion à la base de données
require 'navbar.php';

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


                header('Location: index.php'); // Redirige vers le profil
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>