
<?php

// use PHPMailer\PHPMailer\PHPMailer;

// session_start();
require 'config.php'; // Fichier de connexion à la base de données
require 'navbar.php';

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

if (isset($_GET['message']) && $_GET['message'] == 'compte_supprime') {
    echo '<div class="alert alert-success">Votre compte et toutes les données associées ont été supprimés.</div>';
}

if (isset($_POST['valider'])) {
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
}


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <h2>Formulaire d'inscription</h2>
    <form action="" method="POST">

        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" value="Dupont" required><br><br>

        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" value="Jean" required><br><br>

        <label for="date_naissance">Date de naissance:</label>
        <input type="date" id="date_naissance" name="date_naissance" value="1990-01-01" required><br><br>

        <label for="adresse">Adresse:</label>
        <input type="text" id="adresse" name="adresse" value="123 Rue de Paris" required><br><br>

        <label for="telephone">Téléphone:</label>
        <input type="tel" id="telephone" name="telephone" value="0123456789" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="jean.dupont@example.com" required><br><br>

        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="confirm_password">Confirmer le mot de passe:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br><br>

        <input type="submit" value="S'inscrire" name="valider">
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>