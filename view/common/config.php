<?php

// ------------------------------------------
// FICHIER CONFIGURATION <<<<<<<<<<<<<<<<<<<<
// ------------------------------------------

try
{
    
    // Connexion à la base de donnée
    
    $db = new PDO('mysql:host=localhost;dbname=reservationsalles', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

catch (Exception $e)

{
        die('Erreur : ' . $e->getMessage());
}

?>
