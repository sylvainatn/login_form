<?php
// connexion à la BDD
$host = "localhost";
$dbname = "login";
$username = "root";
$password = "root";
$bdd = new PDO("mysql:host=$host;dbname=$dbname;", "$username", "$password");
?>