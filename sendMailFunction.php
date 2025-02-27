<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
require 'PHPMailer\src\Exception.php';
require 'PHPMailer\src\PHPMailer.php';
require 'PHPMailer\src\SMTP.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

function EnvoieMail($mail, $mailToSend, $userName, $verificationCode) {

    //Server settings
    $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'matheomousse.contact@gmail.com';                     //SMTP username
    $mail->Password   = 'qjwlmjsyejupdkcy';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('matheomousse.contact@gmail.com', 'Mailer');
    $mail->addAddress($mailToSend, 'User');     //Add a recipient

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Validation de votre compte';
    $mail->CharSet = 'UTF-8';
    $mail->Body    = '
        <!DOCTYPE html>
        <html lang="fr">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Formulaire</title>
            
            <style>
                .container {
                    font-family: Arial, sans-serif;
                    margin: 0 auto;
                    padding: 20px;
                    max-width: 600px;
                    background-color: #f4f4f4;
                    border: 1px solid #ddd;
                    border-radius: 10px;
                }
                .header {
                    text-align: center;
                    padding: 10px 0;
                    background-color: #007bff;
                    color: white;
                    border-radius: 10px 10px 0 0;
                }
                .content {
                    padding: 20px;
                    text-align: center;
                }
                .footer {
                    text-align: center;
                    padding: 10px 0;
                    background-color: #007bff;
                    color: white;
                    border-radius: 0 0 10px 10px;
                }
                .verification-code {
                    font-size: 24px;
                    font-weight: bold;
                    color: #007bff;
                }
                .p {
                    color:rgb(0, 0, 0);
                }
                
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1>Validation de votre compte</h1>
                </div>
                <div class="content">
                    <p>Bonjour '.$userName.',</p>
                    <p>Merci de vérifier votre adresse e-mail en cliquant sur le lien ci-dessous :</p>
                    <p><a href="'.$verificationCode.'" class="verification-link">Vérifier mon adresse e-mail</a></p>
                </div>
                <div class="footer">
                    <p>&copy; 2025 Mathéo Moussé</p>
                </div>
            </div>
        </body>
        </html>';
    $mail->AltBody = 'Bonjour '.$userName.', Merci de vérifier votre adresse e-mail en cliquant sur le lien suivant : '.$verificationCode;

    $mail->send();
}