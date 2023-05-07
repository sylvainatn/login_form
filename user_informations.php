<?php
session_start();
if($_SESSION['autoriser'] != 'oui') 
{
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Mes informations</title>
</head>
<body background="images/fond.webp">
    <h2 class="titre">Mes Informations personnelles</h2>
    <a href="deconnexion.php"><img src="images/deconnexion.jpg" alt="déconnexion" class="disconnect-button"></a>
    <table>
        <tr>
            <td>Nom</td>
            <td><?php echo $_SESSION['nom']; ?></td>
        </tr>
        <tr>
            <td>Prénom</td>
            <td><?php echo $_SESSION['prénom']; ?></td>
        </tr>
        <tr>
            <td>Date de Naissance</td>
            <td><?php echo $_SESSION['date']; ?></td>
        </tr>
        <tr>
            <td>Adresse</td>
            <td><?php echo $_SESSION['adresse']; ?></td>
        </tr>
        <tr>
            <td>Photo</td>
            <td><?php echo $_SESSION['photo']; ?></td>
        </tr>
        <tr>
            <td>E-mail</td>
            <td><?php echo $_SESSION['email']; ?></td>
        </tr>
        <tr>
            <td>Identifiant</td>
            <td><?php echo $_SESSION['login']; ?></td>
        </tr>
    </table>
</body>
</html>