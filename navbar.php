<?php
session_start();
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">Mon Site</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <?php if (isset($_SESSION['id'])) { ?>
                <li class="nav-item"><a class="nav-link" href="#">Bonjour, <?php echo $_SESSION['prenom'] . ' ' . $_SESSION['nom']; ?></a></li>
                <li class="nav-item"><a class="nav-link" href="mes_rdv.php">Mes Rendez-vous</a></li>
                <li class="nav-item"><a class="nav-link" href="prise_rdv.php">Prendre un Rendez-vous</a></li>
                <li class="nav-item"><a class="nav-link" href="modifier_profil.php">Modifier Profil</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Déconnexion</a></li>
            <?php } else { ?>
                <li class="nav-item"><a class="nav-link" href="connexion.php">Connexion</a></li>
                <li class="nav-item"><a class="nav-link" href="inscription.php">Inscription</a></li>
            <?php } ?>
        </ul>
    </div>
</nav>
