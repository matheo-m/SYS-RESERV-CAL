<?php require 'navbar.php'; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function envoyerMessage(event) {
            event.preventDefault(); // Empêche l'envoi réel du formulaire
            alert("Votre message a bien été envoyé !");
            window.location.href = "index.php"; // Redirection vers la page principale
        }
    </script>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Contactez-nous</h2>
    <p class="text-center">Remplissez ce formulaire pour nous envoyer un message.</p>

    <form onsubmit="envoyerMessage(event)" class="col-md-6 mx-auto">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom :</label>
            <input type="text" class="form-control" id="nom" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email :</label>
            <input type="email" class="form-control" id="email" required>
        </div>

        <div class="mb-3">
            <label for="message" class="form-label">Message :</label>
            <textarea class="form-control" id="message" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100">Envoyer</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
