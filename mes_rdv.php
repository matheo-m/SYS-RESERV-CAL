<?php
// session_start();
require 'config.php';
require 'navbar.php';

if (!isset($_SESSION['id'])) {
    header("Location: connexion.php");
    exit();
}

$recupRdv = $bdd->prepare("SELECT * FROM rendez_vous WHERE utilisateur_id = ? ORDER BY date_rdv, heure_rdv");
$recupRdv->execute(array($_SESSION['id']));
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Mes Rendez-vous</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>
    <h2>Mes Rendez-vous</h2>
    <table border="1">
        <tr>
            <th>Date</th>
            <th>Heure</th>
            <th>Statut</th>
            <th>Action</th>
        </tr>
        <?php while ($rdv = $recupRdv->fetch()) { ?>
            <tr>
                <td><?= htmlspecialchars($rdv['date_rdv']) ?></td>
                <td><?= htmlspecialchars($rdv['heure_rdv']) ?></td>
                <td><?= htmlspecialchars($rdv['statut']) ?></td>
                <td>
                    <a href="annuler_rdv.php?id=<?= $rdv['id'] ?>">Annuler</a>
                </td>
            </tr>
        <?php } ?>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>