<?php
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
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4 text-primary text-center">Mes Rendez-vous</h2>

        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center">
                <thead class="table-primary">
                    <tr>
                        <th>Date</th>
                        <th>Heure</th>
                        <th>Statut</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($rdv = $recupRdv->fetch()) { ?>
                        <tr>
                            <td><?= htmlspecialchars($rdv['date_rdv']) ?></td>
                            <td><?= htmlspecialchars($rdv['heure_rdv']) ?></td>
                            <td>
                                <span class="badge 
                                    <?= ($rdv['statut'] == 'confirmé') ? 'bg-success' : 'bg-warning' ?>">
                                    <?= htmlspecialchars($rdv['statut']) ?>
                                </span>
                            </td>
                            <td>
                                <a href="annuler_rdv.php?id=<?= $rdv['id'] ?>" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Êtes-vous sûr de vouloir annuler ce rendez-vous ?');">
                                    Annuler
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="text-center mt-4">
            <a href="prise_rdv.php" class="btn btn-primary">Prendre un nouveau rendez-vous</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
