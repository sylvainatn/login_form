<?php
session_start();
$email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Confirmation de l'email</title>
</head>
<body background="images/fond.webp">
    <div class="cadre">
        <h2>Confirmer votre Adresse email</h2>
        <style>h2 {text-align: center;}</style>
        <p>Un mail vous a été envoyé à l'adresse suivante : <?php echo @$email; ?></p>
        <p>1. Ouvrez votre boîte mail</p>
        <p>2. Valider votre adresse e-mail en cliquant sur le lien</p>
    </div>
</body>
</html>