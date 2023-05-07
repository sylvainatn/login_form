<?php
session_start();
if(isset($_POST['valider'])) 
{
    include('connexion_bdd.php');
    $stmt1 = $bdd -> prepare('SELECT * FROM users WHERE login = ? AND password = ? AND clé = ? limit 1'); // sélectionne tout les id où le login correspond au login saisit par l'utilisateur
    $stmt1 -> execute(array($_POST['login'], md5($_POST['password']), "1")); // éxecute la requête
    $stmt1 -> setFetchMode(PDO::FETCH_ASSOC); // retourne un tableau indexé par le nom de la colonne id
    $tab = $stmt1 -> fetchAll(); // retourne l'ensemble des résultats de la requête
    if(count($tab) == 1) 
    { // si le login et le mot de passe correspondent
        $stmt2 = $bdd -> prepare('UPDATE users SET token = NULL WHERE login = ?'); // on met à null le token dès que l'utilisteur se connecte pour la première fois
        $stmt2 -> execute(array($_POST['login']));
        $_SESSION['autoriser'] = 'oui';
        $_SESSION['nom'] = $tab[0]['nom'];
        $_SESSION['prénom'] = $tab[0]['prénom'];
        $_SESSION['date'] =  date("d/m/Y", strtotime($tab[0]['date']));
        $_SESSION['adresse'] = $tab[0]['adresse'];
        $_SESSION['photo'] = $tab[0]['photo'];
        $_SESSION['email'] = $tab[0]['email'];
        $_SESSION['login'] = $tab[0]['login'];
        $_SESSION['password'] = $tab[0]['password'];
        header('Location: session.php');
    }
    else 
    { // si le login et/ou le mot de passe ne correspondent pas
        $errorMsg = "<p class='error-message'>Identifiant ou/et mot de passe incorrect</p>"; 
        print "<style>.login-box .user-box .login { border-bottom: 1px solid red }</style>";
        print "<style>.login-box .user-box .password { border-bottom: 1px solid red }</style>";
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
    <link rel="icon" href="images/login.png">
    <title>Login</title>
</head>
<body background="images/fond.webp">
    <h1 class="titre">Login Form</h1>
    <!-- ZONE DE CONNEXION -->
    <div class="login-box">
        <h2>Login</h2>
        <form method="POST">
            <div class="user-box">
                <input type="text" name="login" class="login" placeholder="Identifiant" required>
                <input type="password" name="password" class="password" placeholder="Mot de passe" required>
                <div class="error-message"><?php echo @$errorMsg ?></div>
            </div>
            <br>
            <a href="mdp_oublie.php">Mot de passe oublié ?</a>
            <style>a {color: white;}</style>
            <br><br>
            <div class="buttons">
                <input type="reset" value="Annuler">
                <input type="submit" name="valider" value="Valider">
                <a href="inscription.php"><input type="button" value="Créer un compte"></a>
            </div>
        </form>
    </div>
</body>
</html>