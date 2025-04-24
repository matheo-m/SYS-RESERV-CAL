<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand text-primary fw-bold" href="index.php">Mon Site</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <?php if (isset($_SESSION['id']) && isset($_SESSION['prenom']) && isset($_SESSION['nom'])) { ?>
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="prise_rdv.php">Prendre un Rendez-vous</a></li>
                <li class="nav-item"><a class="nav-link" href="mes_rdv.php">Mes Rendez-vous</a></li>
                <li class="nav-item"><a class="nav-link" href="modifier_profil.php">Modifier Profil</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
            </ul>

                <div class="d-flex align-items-center">
                    <span class="me-3 fw-bold text-primary">Bonjour, <?php echo htmlspecialchars($_SESSION['prenom']) . ' ' . $_SESSION['nom']; ?></span>
                    <a href="logout.php" class="btn btn-outline-danger">Déconnexion</a>
                </div>
            <?php } else { ?>
                <a href="connexion.php" class="btn btn-primary me-2">Connexion</a>
                <a href="inscription.php" class="btn btn-outline-primary">Inscription</a>
            <?php } ?>
        </div>
    </div>
</nav>