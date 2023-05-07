<?php
session_start();
if(isset($_POST['valider'])) 
{
    if($_POST['pwd'] != $_POST['repwd']) 
    { // si les mots de passe ne sont pas identiques
        $errorMsg1 = "<p class='error-message'>Mots de passe non identiques</p>"; 
        print "<style>.login-box .user-box .password { border-bottom: 1px solid red }</style>";
    }
    else { 
        include('connexion_bdd.php');
        $stmt1 = $bdd -> prepare('SELECT id FROM users WHERE login = ? limit 1'); // sélectionne tout les id où le login correspond au login saisit par l'utilisateur
        $stmt1 -> execute(array($_POST['login'])); // éxecute la requête
        $stmt2 = $bdd -> prepare('SELECT id FROM users WHERE email = ? limit 1'); // sélectionne tout les id où l'email correspond à l'email saisit par l'utilisateur
        $stmt2 -> execute(array($_POST['email'])); // éxecute la requête
        if($stmt1 -> rowCount() == 1) 
        { // si le login existe déjà dans la BDD
            $errorMsg2 = "<p class='error-message'>L'identifiant saisit est indisponible</p>";
            print "<style>.login-box .user-box .login { border-bottom: 1px solid red }</style>";
        } 
        elseif($stmt2 -> rowCount() == 1) 
        { // si l'email existe déjà dans la BDD
            $errorMmsg3 = "<p class='error-message'>L'email saisit est indisponible</p>";
            print "<style>.login-box .user-box .email { border-bottom: 1px solid red }</style>"; 
        } 
        else 
        { // validation du compte par mail
            $token = uniqid();
            $url = "http://localhost:3000/validation_compte?token=$token";
            $subject = "Vérifiez votre compte";
            $message = "Cliquez sur le lien suivant pour vérifier votre compte : $url";
            if(mail($_POST['email'], $subject, $message)) 
            { // si le mail est envoyé
                $insertion = $bdd -> prepare("INSERT INTO users(nom, prénom, date, adresse, photo, email, login, password, token) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)"); 
                $insertion -> execute(array($_POST['nom'], $_POST['prénom'], $_POST['date'], $_POST['adresse'], $_POST['photo'], $_POST['email'], $_POST['login'], md5($_POST['pwd']), $token)); // insert toutes les données de l'utilisateurs dans la BDD
                $_SESSION['email'] = $_POST['email'];
                header('Location: verification_email.php');
            } 
            else 
            {
                echo "<h3 class='erreurSurvenu'>Une erreur est survenu, veuillez vérifier votre connexion internet.</h3>";
            } 
        }
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
    <title>Inscription</title>
</head>
<body background="images/fond.webp">
    <!-- ZONE D'INSCRIPTION -->
    <div class="login-box">
        <h2>Inscription</h2>
        <form method="POST">
            <div class="user-box">
                <input type="text" name="nom" placeholder="Nom" required>
                <input type="text" name="prénom" placeholder="Prénom" required>
                <input type="date" name="date" required>
                <input type="text" name="adresse" placeholder="Adresse de résidence" required>
                <input type="email" name="email" class="email" placeholder="Entrer une adresse mail" required>
                <div><?php echo @$errorMsg3 ?></div>
                <input type="text" name="login" class="login" placeholder="Entrer un identifiant" required>
                <div><?php echo @$errorMsg2 ?></div>
                <input type="password" name="pwd" class="password" placeholder="Entrer un mot de passe" required>
                <input type="password" name="repwd" class="password" placeholder="Confirmer votre mot de passe" required>
                <div><?php echo @$errorMsg1 ?></div>
                <dl>Ajouter une photo<input type="file" name="photo" required></dl>
                <style>dl {color: white;}</style>
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