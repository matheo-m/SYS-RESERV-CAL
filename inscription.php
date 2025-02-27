<?php

session_start();
require 'config.php'; // Fichier de connexion à la base de données

use PHPMailer\PHPMailer\PHPMailer;

$message = filter_input(INPUT_POST, "message", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$mailToSend = filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$btn = filter_input(INPUT_POST, "envoyer", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

 require_once 'sendMailFunction.php'; // récupère la fonction d'envoi de mail

if (isset($btn) && $btn == "envoyer") {
    $userName = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    // Generate a 6-digit verification code
    $verificationCode = rand(100000, 999999);

    // Insert the verification code into the database
    $query = $db->prepare("INSERT INTO users (username, email, verification_code) VALUES (:username, :email, :verification_code)");
    $query->bindParam("username", $userName, PDO::PARAM_STR);
    $query->bindParam("email", $mailToSend, PDO::PARAM_STR);
    $query->bindParam("verification_code", $verificationCode, PDO::PARAM_INT);
    $query->execute();

    $mail = new PHPMailer(true);
    EnvoieMail($mail, $mailToSend, $userName, $verificationCode);
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire</title>
    <link rel="stylesheet" href="assets\css\style.css">
</head>

<body>
    <div class="form-container">
        <h2>Formulaire d'inscription</h2>
        <form action="#" method="POST">
            <div class="form-group">
                <label for="username">Nom d'utilisateur :</label>
                <input type="text" id="username" name="username" placeholder="Votre nom d'utilisateur" autocomplete="off" required>
            </div>
            <div class="form-group">
                <label for="email">Adresse e-mail :</label>
                <input type="email" id="email" name="email" placeholder="Votre e-mail" autocomplete="off" required>
            </div>
            <button type="submit" name="envoyer" value="envoyer" class="submit-btn">Envoyer</button>
        </form>
    </div>

</body>

</html>
