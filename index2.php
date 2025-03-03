<?php
require 'navbar.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Prise de RDV Médecin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="text-center">
            <h1 class="mb-4 fw-bold">Trouvez un professionnel de santé et prenez rendez-vous</h1>
            <p class="mb-4">Prenez rendez-vous en ligne rapidement et simplement</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="inscription.php" class="btn text-white px-4 py-2" style="background-color: #0060df; border-radius: 8px; font-size: 1.2rem;">S'inscrire</a>
                <a href="connexion.php" class="btn text-dark px-4 py-2" style="background-color: #ffcc00; border-radius: 8px; font-size: 1.2rem;">Se connecter</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>
