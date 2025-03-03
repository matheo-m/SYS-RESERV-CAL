<?php
require 'config.php';
require 'navbar.php';

if (!isset($_SESSION['id'])) {
    header("Location: connexion.php");
    exit;
}

// Générer un token CSRF s'il n'existe pas
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Si le formulaire est soumis pour mettre à jour les informations
if (isset($_POST['modifier'])) {
    if (!empty($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $date_naissance = $_POST['date_naissance'];
        $adresse = htmlspecialchars($_POST['adresse']);
        $telephone = htmlspecialchars($_POST['telephone']);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

        // Mise à jour des informations dans la base de données
        $updateUser = $bdd->prepare('UPDATE utilisateurs SET nom = ?, prenom = ?, date_naissance = ?, adresse = ?, telephone = ?, email = ? WHERE id = ?');
        $updateUser->execute(array($nom, $prenom, $date_naissance, $adresse, $telephone, $email, $_SESSION['id']));

        // Actualisation des informations dans la session
        $_SESSION['nom'] = $nom;
        $_SESSION['prenom'] = $prenom;
        $_SESSION['date_naissance'] = $date_naissance;
        $_SESSION['adresse'] = $adresse;
        $_SESSION['telephone'] = $telephone;
        $_SESSION['email'] = $email;

        $message = "Informations mises à jour avec succès.";
    } else {
        $message = "Échec de validation du token CSRF.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - Modifier mes informations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Bonjour, <?= htmlspecialchars($_SESSION['prenom']) ?> <?= htmlspecialchars($_SESSION['nom']) ?> !</h2>

        <?php if (isset($message))
            echo '<div class="alert alert-success">' . $message . '</div>'; ?>

        <h3>Modifier mes informations</h3>

        <?php
        // echo "<pre>";
        // print_r($_SESSION);
        // echo "</pre>";
        ?>
        
        <form action="" method="POST">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

            <div class="form-group">
                <label for="nom">Nom :</label>
                <input type="text" class="form-control" name="nom" value="<?= htmlspecialchars($_SESSION['nom']) ?>"
                    required>
            </div>

            <div class="form-group">
                <label for="prenom">Prénom :</label>
                <input type="text" class="form-control" name="prenom"
                    value="<?= htmlspecialchars($_SESSION['prenom']) ?>" required>
            </div>

            <div class="form-group">
                <label for="date_naissance">Date de naissance :</label>
                <input type="date" class="form-control" name="date_naissance" value="<?= $_SESSION['date_naissance'] ?>"
                    required>
            </div>

            <div class="form-group">
                <label for="adresse">Adresse :</label>
                <input type="text" class="form-control" name="adresse"
                    value="<?= htmlspecialchars($_SESSION['adresse']) ?>" required>
            </div>

            <div class="form-group">
                <label for="telephone">Téléphone :</label>
                <input type="tel" class="form-control" name="telephone"
                    value="<?= htmlspecialchars($_SESSION['telephone']) ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" class="form-control" name="email"
                    value="<?= htmlspecialchars($_SESSION['email']) ?>" required>
            </div>

            <button type="submit" class="btn btn-primary" name="modifier">Modifier mes informations</button>
        </form>

        <form action="supprimer_compte.php" method="POST">
            <button type="submit" class="btn btn-danger" name="supprimer_compte"
                onclick="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.')">
                Supprimer mon compte
            </button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>