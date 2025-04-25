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

$erreur = '';  // Variable pour stocker l'erreur

if (isset($_POST['valider'])) {
    if (!empty($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        if (!empty($_POST['date_rdv']) && !empty($_POST['heure_rdv']) && !empty($_POST['minute_rdv'])) {
            $date_rdv = $_POST['date_rdv'];
            $heure_rdv = $_POST['heure_rdv'] . ':' . $_POST['minute_rdv']; // Combinaison de l'heure et des minutes

            // Vérifie que l'heure est sur un créneau valide (00 ou 30 minutes)
            $time = DateTime::createFromFormat('H:i', $heure_rdv);
            $minutes = (int) $time->format('i');

            if ($minutes !== 0 && $minutes !== 30) {
                $erreur = "<div class='alert alert-danger'>Les rendez-vous ne peuvent être pris qu'à 00 ou 30 minutes.</div>";
            }

            if (empty($erreur)) {
                // Vérification de la disponibilité
                $verifDispo = $bdd->prepare("SELECT COUNT(*) FROM rendez_vous WHERE date_rdv = ? AND heure_rdv = ? AND statut = 'confirmé'");
                $verifDispo->execute(array($date_rdv, $heure_rdv));
                $dispo = $verifDispo->fetchColumn();

                if ($dispo == 0) {
                    // Insérer le rendez-vous
                    $insertRdv = $bdd->prepare("INSERT INTO rendez_vous (utilisateur_id, date_rdv, heure_rdv, statut) VALUES (?, ?, ?, 'confirmé')");
                    $insertRdv->execute(array($_SESSION['id'], $date_rdv, $heure_rdv));

                    $erreur = "<div class='alert alert-success'>Rendez-vous pris avec succès !</div>";
                } else {
                    $erreur = "<div class='alert alert-danger'>Ce créneau est déjà réservé, veuillez en choisir un autre.</div>";
                }
            }
        } else {
            $erreur = "<div class='alert alert-warning'>Veuillez remplir tous les champs.</div>";
        }
    } else {
        $erreur = "<div class='alert alert-danger'>Échec de validation du token CSRF.</div>";
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

        <!-- Affichage de l'erreur (ou du succès) -->
        <?= $erreur; ?>

        <form action="" method="POST">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

            <label for="date_rdv">Date :</label>
            <input type="date" id="date_rdv" name="date_rdv" value="<?= htmlspecialchars($date_rdv) ?>"
                required><br><br>

            <label for="heure_rdv">Heure :</label>
            <div class="d-flex">
                <!-- Menu déroulant pour les heures de 8h à 18h -->
                <select id="heure_rdv" name="heure_rdv" required>
                    <?php
                    for ($h = 8; $h <= 18; $h++) {
                        $selected = ($heure_rdv && substr($heure_rdv, 0, 2) == $h) ? 'selected' : '';
                        echo "<option value='" . sprintf('%02d', $h) . "' $selected>" . sprintf('%02d', $h) . "</option>";
                    }
                    ?>
                </select>

                <!-- Menu déroulant pour les minutes (00 ou 30) -->
                <select name="minute_rdv" required>
                    <option value="00" <?= ($heure_rdv && substr($heure_rdv, 3, 2) == '00') ? 'selected' : '' ?>>00
                    </option>
                    <option value="30" <?= ($heure_rdv && substr($heure_rdv, 3, 2) == '30') ? 'selected' : '' ?>>30
                    </option>
                </select>
            </div><br><br>

            <input type="submit" value="Réserver" name="valider" class="btn btn-primary">
        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>