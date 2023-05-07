<?php
session_start();
if($_SESSION['autoriser'] != 'oui') 
{
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Mon Compte</title>
</head>
<body background="images/fond.webp">
    <a href="qrcode.php">QR code/Badge</a>
    <a href="deconnexion.php"><img src="images/deconnexion.jpg" alt="déconnexion" class="disconnect-button"></a>
    <h2 class="userName"><?php echo "Bonjour", " ", $_SESSION['nom'], " ", $_SESSION['prénom'] ?></h2>
</body>
</html> 