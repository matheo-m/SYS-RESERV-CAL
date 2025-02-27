<?php

use PHPMailer\PHPMailer\PHPMailer;

session_start();
require 'config.php'; // Fichier de connexion à la base de données

require_once 'sendMailFunction.php'; // récupère la fonction d'envoi de mail

if (isset($_POST['valider'])) {
    if (!empty($_POST['email'])) {
        $cle = rand(100000, 999999);
        $email = $_POST['email'];
        $insererUser = $bdd->prepare("INSERT INTO utilisateurs (email, cle, confirme) VALUES (?, ?, ?)");
        $insererUser->execute(array($email, $cle, 0));

        $recupUser = $bdd->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $recupUser->execute(array($email));

        if ($recupUser->rowCount() > 0) {
            $userInfos = $recupUser->fetch();
            $_SESSION['id'] = $userInfos['id'];

            function smtpmailer($to, $body)
            {
                $mail = new PHPMailer();
                //Server settings
                $mail->SMTPDebug = 0;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth = true;                                   //Enable SMTP authentication
                $mail->Username = 'matheomousse.contact@gmail.com';                     //SMTP username
                $mail->Password = 'qjwlmjsyejupdkcy';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('matheomousse.contact@gmail.com', 'Mailer');
                $mail->addAddress($to, 'User');     //Add a recipient

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Validation de votre compte';
                $mail->CharSet = 'UTF-8';
                $mail->AddReplyTo('matheomousse.contact@gmail.com', 'Mailer');

                $mail->Body = $body;

                if (!$mail->Send()) {
                    $error = "Mailer Error: " . $mail->ErrorInfo;

                    return $error;
                } else {
                    $error = "Thanks You !! Your email is sent.";

                    return $error;
                }
            }

            $to = $email;
            $msg = 'http://localhost/mes_projets/SYS-RESERV-CAL/verif.php?id=' . $_SESSION['id'] . '&cle=' . $cle;

            $error = smtpmailer($to, $msg);
        }
    } else {
        echo "Veuillez renseigner votre email";
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
    <form action="" method="POST">

        <!-- <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" required><br><br>

        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" required><br><br>

        <label for="date_naissance">Date de naissance:</label>
        <input type="date" id="date_naissance" name="date_naissance" required><br><br>

        <label for="adresse">Adresse:</label>
        <input type="text" id="adresse" name="adresse" required><br><br> -->

        <!-- <label for="telephone">Téléphone:</label>
        <input type="tel" id="telephone" name="telephone" required><br><br> -->

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <input type="submit" value="valider" name="valider">

        <!-- <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required><br><br> -->

        <!-- <label for="confirm_password">Confirmer le mot de passe:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br><br> -->

        <!-- <input type="submit" value="S'inscrire"> -->
    </form>
</body>

</html>