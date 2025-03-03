<?php
// require_once 'sendMailFunction.php'; // récupère la fonction d'envoi de mail

// if (isset($_POST['valider'])) {
//     if (!empty($_POST['email'])) {


//         $cle = rand(100000, 999999);
//         $email = $_POST['email'];
//         $insererUser = $bdd->prepare("INSERT INTO utilisateurs (email, cle, confirme) VALUES (?, ?, ?)");
//         $insererUser->execute(array($email, $cle, 0));

//         $recupUser = $bdd->prepare("SELECT * FROM utilisateurs WHERE email = ?");
//         $recupUser->execute(array($email));

//         if ($recupUser->rowCount() > 0) {
//             $userInfos = $recupUser->fetch();
//             $_SESSION['id'] = $userInfos['id'];

//             function smtpmailer($to, $body)
//             {
//                 $mail = new PHPMailer();
//                 //Server settings
//                 $mail->SMTPDebug = 0;                      //Enable verbose debug output
//                 $mail->isSMTP();                                            //Send using SMTP
//                 $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
//                 $mail->SMTPAuth = true;                                   //Enable SMTP authentication
//                 $mail->Username = 'matheomousse.contact@gmail.com';                     //SMTP username
//                 $mail->Password = 'qjwlmjsyejupdkcy';                               //SMTP password
//                 $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
//                 $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

//                 //Recipients
//                 $mail->setFrom('matheomousse.contact@gmail.com', 'Mailer');
//                 $mail->addAddress($to, 'User');     //Add a recipient

//                 //Content
//                 $mail->isHTML(true);                                  //Set email format to HTML
//                 $mail->Subject = 'Validation de votre compte';
//                 $mail->CharSet = 'UTF-8';
//                 $mail->AddReplyTo('matheomousse.contact@gmail.com', 'Mailer');

//                 $mail->Body = $body;

//                 if (!$mail->Send()) {
//                     $error = "Mailer Error: " . $mail->ErrorInfo;

//                     return $error;
//                 } else {
//                     $error = "Thanks You !! Your email is sent.";

//                     return $error;
//                 }
//             }

//             $to = $email;
//             $msg = 'Cliquez sur le lien suivant pour activer votre compte : 
//             <a href="http://localhost/mes_projets/SYS-RESERV-CAL/verif.php?id=' . $_SESSION['id'] . '&cle=' . $cle . '">Activer mon compte</a>';


//             $error = smtpmailer($to, $msg);
//         }
//     } else {
//         echo "Veuillez renseigner votre email";
//     }
// }
?>
<?php
require 'config.php';
require 'navbar.php';

// Générer un token CSRF s'il n'existe pas
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if (isset($_GET['message']) && $_GET['message'] == 'compte_supprime') {
    echo '<div class="alert alert-success">Votre compte et toutes les données associées ont été supprimés.</div>';
}

if (isset($_POST['valider'])) {
    if (!empty($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['date_naissance']) && !empty($_POST['adresse']) && !empty($_POST['telephone'])) {

            $nom = htmlspecialchars($_POST['nom']);
            $prenom = htmlspecialchars($_POST['prenom']);
            $date_naissance = $_POST['date_naissance'];
            $adresse = htmlspecialchars($_POST['adresse']);
            $telephone = htmlspecialchars($_POST['telephone']);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash du mot de passe

            // Vérifier si l'email existe déjà
            $checkEmail = $bdd->prepare("SELECT id FROM utilisateurs WHERE email = ?");
            $checkEmail->execute(array($email));

            if ($checkEmail->rowCount() > 0) {
                echo "Cet email est déjà utilisé.";
            } else {
                // Insérer l'utilisateur en base de données
                $insererUser = $bdd->prepare("INSERT INTO utilisateurs (nom, prenom, date_naissance, adresse, telephone, email, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $insererUser->execute(array($nom, $prenom, $date_naissance, $adresse, $telephone, $email, $password));

                echo "Inscription réussie ! Vous pouvez maintenant vous connecter.";
            }
        } else {
            echo "Veuillez remplir tous les champs.";
        }
    } else {
        echo "Échec de validation du token CSRF.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Formulaire d'inscription</h2>
        <form action="" method="POST" class="needs-validation" novalidate>
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

            <div class="mb-3">
                <label for="nom" class="form-label">Nom:</label>
                <input type="text" id="nom" name="nom" class="form-control" value="Dupont" required>
                <div class="invalid-feedback">Veuillez renseigner votre nom.</div>
            </div>

            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom:</label>
                <input type="text" id="prenom" name="prenom" class="form-control" value="Jean" required>
                <div class="invalid-feedback">Veuillez renseigner votre prénom.</div>
            </div>

            <div class="mb-3">
                <label for="date_naissance" class="form-label">Date de naissance:</label>
                <input type="date" id="date_naissance" name="date_naissance" class="form-control" value="1990-01-01"
                    required>
                <div class="invalid-feedback">Veuillez renseigner votre date de naissance.</div>
            </div>

            <div class="mb-3">
                <label for="adresse" class="form-label">Adresse:</label>
                <input type="text" id="adresse" name="adresse" class="form-control" value="123 Rue de Paris" required>
                <div class="invalid-feedback">Veuillez renseigner votre adresse.</div>
            </div>

            <div class="mb-3">
                <label for="telephone" class="form-label">Téléphone:</label>
                <input type="tel" id="telephone" name="telephone" class="form-control" value="0123456789" required>
                <div class="invalid-feedback">Veuillez renseigner votre numéro de téléphone.</div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control" value="jean.dupont@example.com"
                    required>
                <div class="invalid-feedback">Veuillez renseigner votre email.</div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe:</label>
                <input type="password" id="password" name="password" class="form-control" required>
                <div class="invalid-feedback">Veuillez renseigner votre mot de passe.</div>
            </div>

            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirmer le mot de passe:</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                <div class="invalid-feedback">Veuillez confirmer votre mot de passe.</div>
            </div>

            <button type="submit" class="btn btn-primary" name="valider">S'inscrire</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>