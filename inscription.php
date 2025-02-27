<?php
require "PHPMailer/PHPMailerAutoload.php";
require 'config.php'; // Fichier de connexion à la base de données

if(isset($_POST['valider'])){
    if (!empty($_POST['email'])){
        $cle = rand(100000, 999999);
        $email = $_POST['email'];
        $insererUser = $bdd->prepare("INSERT INTO utilisateurs (email, cle, confirme) VALUES (?, ?, ?)");
        $insererUser->execute(array($email, $cle, 0));

        $recupUser = $bdd->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $recupUser->execute(array($email));
        if ($recupUser->rowCount() > 0) {
            $userInfos = $recupUser->fetch();
            $_SESSION['id'] = $userInfos['id'];



            function smtpmailer($to, $from, $from_name, $subject, $body)
            {
                $mail = new PHPMailer();
                $mail->IsSMTP();
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Utiliser STARTTLS au lieu de SSL
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = 587;  // Port correct pour STARTTLS
                $mail->Username = 'matheomousse.contact@gmail.com';
                $mail->Username = 'matheomousse.contact@gmail.com';
                $mail->Password = 'pltd esfi wgvw rmtw ';
        
            //   $path = 'reseller.pdf';
            //   $mail->AddAttachment($path);
        
                $mail->IsHTML(true);
                $mail->From="matheomousse.contact@gmail.com";
                $mail->FromName=$from_name;
                $mail->Sender=$from;
                $mail->AddReplyTo($from, $from_name);
                $mail->Subject = $subject;
                $mail->Body = $body;
                $mail->AddAddress($to);
                $mail->SMTPDebug = 2; // Enable verbose debug output
                $mail->Debugoutput = 'html'; // Output format for debug information
                if(!$mail->Send())
                {
                    $error = "Mailer Error: " . $mail->ErrorInfo;
                    return $error; 
                }
                else 
                {
                    $error = "Thanks You !! Your email is sent.";  
                    return $error;
                }
                
            }
            
            $to   = $email;
            $from = 'matheomousse.contact@gmail.com';
            $name = 'Matheo';
            $subj = 'Email de confirmation de compte';
            $msg = 'http://localhost/verif.php?id='.$_SESSION['id'].'&cle='.$cle;
            
            $error=smtpmailer($to,$from, $name ,$subj, $msg);

        }

    }else{
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
        <input type="text" id="adresse" name="adresse" required><br><br>

        <label for="telephone">Téléphone:</label>
        <input type="tel" id="telephone" name="telephone" required><br><br> -->

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <input type="submit" value="Valider" name="valider">

        <!-- <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="confirm_password">Confirmer le mot de passe:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br><br>

        <input type="submit" value="S'inscrire"> -->
    </form>

</body>
</html>