    <?php
    require 'config.php'; // Fichier de connexion à la base de données

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupérer et sécuriser les données du formulaire
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $date_naissance = $_POST['date_naissance'];
        $adresse = htmlspecialchars($_POST['adresse']);
        $telephone = htmlspecialchars($_POST['telephone']);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $token = bin2hex(random_bytes(50)); // Générer un token unique

        // Vérifier si l'email existe déjà
        $checkEmail = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = ?");
        $checkEmail->execute([$email]);
        if ($checkEmail->rowCount() > 0) {
            die("Cet email est déjà utilisé.");
        }

        // Insérer l'utilisateur dans la base de données
        $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, prenom, date_naissance, adresse, telephone, email, mot_de_passe, token, actif) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0)");
        if ($stmt->execute([$nom, $prenom, $date_naissance, $adresse, $telephone, $email, $password, $token])) {
            // Envoi d'email de confirmation
            $verification_link = "http://ton-site.com/verification.php?email=$email&token=$token";
            mail($email, "Vérification de votre compte", "Cliquez sur ce lien pour activer votre compte : $verification_link");
            echo "Inscription réussie ! Vérifiez votre email pour activer votre compte.";
        } else {
            echo "Erreur lors de l'inscription.";
        }
    }
    ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
    <h2>Formulaire d'inscription</h2>
    <form action="inscription.php" method="post">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" required><br><br>

        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" required><br><br>

        <label for="date_naissance">Date de naissance:</label>
        <input type="date" id="date_naissance" name="date_naissance" required><br><br>

        <label for="adresse">Adresse:</label>
        <input type="text" id="adresse" name="adresse" required><br><br>

        <label for="telephone">Téléphone:</label>
        <input type="tel" id="telephone" name="telephone" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="confirm_password">Confirmer le mot de passe:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br><br>

        <input type="submit" value="S'inscrire">
    </form>

</body>
</html>