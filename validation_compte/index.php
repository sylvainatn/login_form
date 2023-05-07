<?php
if(isset($_GET['token']) && $_GET['token'] != '') 
{
    include('../connexion_bdd.php');
    $stmt1 = $bdd -> prepare('SELECT email FROM users WHERE token = ?');
    $stmt1 -> execute(array($_GET['token']));
    $email = $stmt1 -> fetchColumn();
    if($email) 
    {
        $stmt2 = $bdd -> prepare('UPDATE users SET clé = ? WHERE token = ?');
        $stmt2 -> execute(array("1", $_GET['token']));
        echo "Votre compte a été validé.<br>"; 
        echo "Vous pouvez maintenant vous connecter.<br><br>";
        echo "<a href='../'>Revenir à la page d'accueil</a>";
    }
    else 
    {
        echo "Erreur 404";
    }
}
?>