<?php
include('../connexion_bdd.php');
if(isset($_GET['token']) && $_GET['token'] != '') 
{ // sélectionne l'email qui correspond au token
    $stmt = $bdd -> prepare('SELECT email FROM users WHERE token = ?'); 
    $stmt -> execute(array($_GET['token'])); // éxecute la requête
    $email = $stmt -> fetchColumn();
    if(isset($_POST['valider'])) 
    {
        if($_POST['newPwd1'] == $_POST['newPwd2']) 
        {
            $stmt = $bdd -> prepare('UPDATE users SET password = ?, token = NULL WHERE email = ?'); // on insert le nouveau mot de passe dans la BDD
            $stmt -> execute(array(md5($_POST['newPwd1']), $email));
            $msg = "<p class='passwordChanged'>Le mot de passe a été modifié.</p>";
        }
        else 
        { // les mots de passe ne sont pas identiques
            $error_msg = "<p class='error-message'>Les mots de passe ne sont pas identiques</p>";
            print "<style>.login-box .user-box .password { border-bottom: 1px solid red }</style>";
        }
    }
    if($email) 
    { // si l'email existe on affiche la page
        ?>        
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="/css/style.css">
            <title>Réinitialisation</title>
        </head>
        <body background="images/fond.webp">
            <h1 class="titre">Récupération du mot de passe</h1>
            <div><?php echo @$msg; ?></div>
            <div class="login-box">
                <h2>Mot de passe</h2>
                <form method="POST">
                    <div class="user-box">
                        <input type="password" name="newPwd1" class="password" placeholder="Nouveau mot de passe" required>
                        <input type="password" name="newPwd2" class="password" placeholder="Confirmer votre nouveau mot de passe" required>
                        <div><?php echo @$error_msg; ?></div>
                    </div>
                    <div class="buttons">
                        <a href="index.php"><input type="button" value="Retour"></a>
                        <input type="reset" value="Annuler">
                        <input type="submit" name="valider" value="Confirmer">
                    </div>
                </form>
            </div>
        </body>
        </html>
        <?php 
    }
    else 
    {
        echo "Erreur 404";
    }
}