<?php
session_start();
require 'config.php';

// Récupération de la semaine demandée
$semaine = isset($_GET['semaine']) ? intval($_GET['semaine']) : 0;
$dateDebut = new DateTime();
$dateDebut->modify("+{$semaine} week")->modify('monday this week');
$dateFin = clone $dateDebut;
$dateFin->modify('+5 days');

$jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
$heures = [];
for ($h = 8; $h <= 18; $h++) {
    $heures[] = sprintf('%02d:00', $h);
    $heures[] = sprintf('%02d:30', $h);
}

// Récupération des rendez-vous déjà pris
$query = $bdd->query("SELECT date_rdv, heure_rdv FROM rendez_vous WHERE statut = 'confirmé'");
$rdv_pris = [];
while ($row = $query->fetch()) {
    $rdv_pris[$row['date_rdv']][] = date('H:i', strtotime($row['heure_rdv']));
}

$aujourdhui = new DateTime(); // Date d'aujourd'hui pour comparaison
$lundi_actuel = new DateTime();
$lundi_actuel->modify('monday this week');

// Désactiver la navigation vers les semaines passées
$desactiver_precedent = $dateDebut < $lundi_actuel;

require 'navbar.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disponibilités</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table th, .table td { text-align: center; vertical-align: middle; }
        .disponible { background-color: #d4edda; color: #155724; }
        .indisponible { background-color: #f8d7da; color: #721c24; }
        .passe { background-color: #ccc; color: #555; }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Disponibilités des rendez-vous</h2>

    <div class="d-flex justify-content-between mb-3">
        <a href="?semaine=<?= $semaine - 1 ?>" class="btn btn-outline-primary <?= $desactiver_precedent ? 'disabled' : '' ?>">← Semaine précédente</a>
        <h4><?= $dateDebut->format('d/m/Y') ?> - <?= $dateFin->format('d/m/Y') ?></h4>
        <a href="?semaine=<?= $semaine + 1 ?>" class="btn btn-outline-primary">Semaine suivante →</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Heures</th>
                    <?php for ($i = 0; $i < 6; $i++) { 
                        $dateJour = clone $dateDebut;
                        $dateJour->modify("+$i days"); ?>
                        <th><?= $jours[$i] ?> <br> <?= $dateJour->format('d/m') ?></th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($heures as $heure) { ?>
                    <tr>
                        <td><strong><?= $heure ?></strong></td>
                        <?php for ($i = 0; $i < 6; $i++) { 
                            $dateJour = clone $dateDebut;
                            $dateJour->modify("+$i days");
                            $dateStr = $dateJour->format('Y-m-d');

                            $estPris = isset($rdv_pris[$dateStr]) && in_array($heure, $rdv_pris[$dateStr]);
                            $estPasse = $dateJour < $aujourdhui;
                            
                            $classe = $estPasse ? 'passe' : ($estPris ? 'indisponible' : 'disponible');
                            $texte = $estPasse ? 'Passé' : ($estPris ? 'Indisponible' : 'Disponible');
                        ?>
                            <td class="<?= $classe ?>">
                                <?= $texte ?>
                                <?php if (!$estPris && !$estPasse) { ?>
                                    <br>
                                    <a href="prise_rdv.php?date=<?= $dateStr ?>&heure=<?= $heure ?>" 
                                       class="btn btn-sm btn-primary">
                                       Réserver
                                    </a>
                                <?php } elseif ($estPris) { ?>
                                    <br>
                                    <button class="btn btn-sm btn-danger" disabled>Indisponible</button>
                                <?php } ?>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>