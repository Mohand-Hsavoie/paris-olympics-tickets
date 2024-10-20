<?php
// config.php

// Informations de la base de données sur Lightsail
define('DB_SERVER', 'ls-d92705bcd1cc8bec065ea69240a65ae4d9d67144.cl6q2ws6qkm9.eu-west-3.rds.amazonaws.com');
define('DB_USERNAME', 'dbmasteruser');
define('DB_PASSWORD', 'T`myo-F%_rG>nV$|>47Wgq2FK}RiZcjd');
define('DB_NAME', 'olympics_ticketing'); // Assurez-vous que c'est le bon nom de votre base

// Connexion à la base de données
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Vérifier la connexion
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>