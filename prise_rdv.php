<?php
// session_start();
require 'config.php'; // Connexion à la base de données
require 'navbar.php';

if (!isset($_SESSION['id'])) {
    header("Location: connexion.php");
    exit();
}

if (isset($_POST['valider'])) {
    if (!empty($_POST['date_rdv']) && !empty($_POST['heure_rdv'])) {
        $date_rdv = $_POST['date_rdv'];
        $heure_rdv = $_POST['heure_rdv'];

        // Vérification de la disponibilité du créneau
        $verifDispo = $bdd->prepare("SELECT * FROM rendez_vous WHERE date_rdv = ? AND heure_rdv = ?");
        $verifDispo->execute(array($date_rdv, $heure_rdv));

        if ($verifDispo->rowCount() == 0) {
            // Créneau disponible, insertion du rendez-vous
            $insertRdv = $bdd->prepare("INSERT INTO rendez_vous (utilisateur_id, date_rdv, heure_rdv, statut) VALUES (?, ?, ?, 'confirmé')");
            $insertRdv->execute(array($_SESSION['id'], $date_rdv, $heure_rdv));

            echo "Rendez-vous pris avec succès !";
        } else {
            echo "Ce créneau est déjà réservé, veuillez en choisir un autre.";
        }
    } else {
        echo "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Prendre un Rendez-vous</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <h2>Prendre un rendez-vous</h2>
    <form action="" method="POST">
        <label for="date_rdv">Date :</label>
        <input type="date" id="date_rdv" name="date_rdv" required><br><br>

        <label for="heure_rdv">Heure :</label>
        <input type="time" id="heure_rdv" name="heure_rdv" required><br><br>

        <input type="submit" value="Valider" name="valider">
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
