<?php
session_start();
require 'config.php'; 

if (!isset($_SESSION['id'])) {
    header("Location: connexion.php");
    exit();
}

// Génération du token CSRF s'il n'existe pas
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Préremplissage avec les données de l'URL
$date_rdv = isset($_GET['date']) ? $_GET['date'] : '';
$heure_rdv = isset($_GET['heure']) ? $_GET['heure'] : '';

if (isset($_POST['valider'])) {
    if (!empty($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        if (!empty($_POST['date_rdv']) && !empty($_POST['heure_rdv'])) {
            $date_rdv = $_POST['date_rdv'];
            $heure_rdv = $_POST['heure_rdv'];
            
            // Vérification de la disponibilité
            $verifDispo = $bdd->prepare("SELECT COUNT(*) FROM rendez_vous WHERE date_rdv = ? AND heure_rdv = ? AND statut = 'confirmé'");
            $verifDispo->execute(array($date_rdv, $heure_rdv));
            $dispo = $verifDispo->fetchColumn();
            
            if ($dispo == 0) {
                // Insérer le rendez-vous
                $insertRdv = $bdd->prepare("INSERT INTO rendez_vous (utilisateur_id, date_rdv, heure_rdv, statut) VALUES (?, ?, ?, 'confirmé')");
                $insertRdv->execute(array($_SESSION['id'], $date_rdv, $heure_rdv));
                
                echo "<div class='alert alert-success'>Rendez-vous pris avec succès !</div>";
            } else {
                echo "<div class='alert alert-danger'>Ce créneau est déjà réservé, veuillez en choisir un autre.</div>";
            }
        } else {
            echo "<div class='alert alert-warning'>Veuillez remplir tous les champs.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Échec de validation du token CSRF.</div>";
    }
}

require 'navbar.php';
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Prendre un Rendez-vous</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Prendre un rendez-vous</h2>
    <form action="" method="POST">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

        <label for="date_rdv">Date :</label>
        <input type="date" id="date_rdv" name="date_rdv" value="<?= htmlspecialchars($date_rdv) ?>" required><br><br>

        <label for="heure_rdv">Heure :</label>
        <input type="time" id="heure_rdv" name="heure_rdv" value="<?= htmlspecialchars($heure_rdv) ?>" required><br><br>

        <input type="submit" value="Réserver" name="valider" class="btn btn-primary">
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
