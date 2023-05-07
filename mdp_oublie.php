<?php
if(isset($_POST['confirmer'])) 
{
    include('connexion_bdd.php');
    $email = $_POST['email'];
    $stmt = $bdd -> prepare('SELECT id FROM users WHERE email = ? limit 1'); // sélectionne tout les id où l'email correspond à l'email saisit par l'utilisateur
    $stmt -> execute(array($email)); // éxecute la requête
    if($stmt -> rowCount() == 1) 
    { // si l'email existe dans la BDD
        $token = uniqid();
        $url = "http://localhost:3000/token?token=$token";
        $subject = "Mot de passe oublié";
        $message = "Bonjour, voici votre lien pour la réinitialisation du mot de passe : $url";
        if(mail($email, $subject, $message)) 
        { // si l'email est envoyé
            $stmt = $bdd -> prepare('UPDATE users SET token = ? WHERE email = ?');
            $stmt -> execute(array($token, $email));
            $msg = "<p class='sendmail'>Mail envoyé</p>";
        } 
        else 
        {
            echo "<h3 class='erreurSurvenu'>Une erreur est survenu, veuillez vérifier votre connexion internet.</h3>";
        }
    }
    else 
    {
        $errorMsg = "<p class='error-message'>Compte non existant</p>";
        print "<style>.login-box .user-box .email { border-bottom: 1px solid red }</style>";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Mot de passe oublié ?</title>
</head>
<body background="images/fond.webp">
    <div class="login-box">
        <form method="POST">
            <h2>Mot de passe oublié</h2>
            <p class="reset-pwd">Veuillez saisir votre email afin de recevoir le lien de réinitialisation de votre mot de passe.</p>
            <div class="user-box">
                <input type="email" name="email" class="email" placeholder="Entrer votre adresse mail" required>
                <div><?php echo @$errorMsg; ?></div>
                <div><?php echo @$msg; ?></div>
            </div>
            <div class="buttons">
                <a href="index.php"><input type="button" value="Retour"></a>
                <input type="submit" name="confirmer" value="Confirmer">
            </div>
        </form>
    </div>
</body>
</html>