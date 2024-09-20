<?php
if ($_SERVER['HTTP_HOST'] == 'localhost') {
    // Configuration pour le développement local
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');  
    define('DB_PASSWORD', '');  
    define('DB_NAME','olympics_ticketing');
} else {
    // Configuration pour Lightsail (production)
    define('DB_SERVER', 'YOUR_LIGHTSAIL_DB_ENDPOINT');  
    define('DB_USERNAME', 'dbmasteruser');  
    define('DB_PASSWORD', 'T`myo-F%_rG>nV$|>47Wgq2FK}RiZcjd');
    define('DB_NAME','olympics_ticketing');
}

// Connexion à la base de données
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Vérifier la connexion
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
echo "Connexion réussie à la base de données!";
?>
