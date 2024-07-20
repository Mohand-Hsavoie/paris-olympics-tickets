<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');  
define('DB_PASSWORD', '');
define('DB_NAME','olympics_ticketing');

// Connexion à la base de données
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Vérifier la connexion
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
echo "Connexion réussie à la base de données!";

?>
