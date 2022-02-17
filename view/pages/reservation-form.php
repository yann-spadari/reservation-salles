<?php


// -------------------------------------------------------
// TRAITEMENT DU FORMULAIRE DE RESERVATION <<<<<<<<<<<<<<<
// -------------------------------------------------------

// Connexion à la base donnée

session_start();

// Connexion à la base de donnée

require '../common/config.php';

// Checker si l'utilisateur est déjà connecté ou pas

if (!isset($_SESSION['id'])) {

    // On redirige vers l'accueil

    header('Location:accueil.php');

}

date_default_timezone_set('Europe/Paris');

?>

<!--Création du formulaire réservation-->

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css" integrity="sha384-i1LQnF23gykqWXg6jxC2ZbCbUMxyw5gLZY6UiUS98LYV5unm8GWmfkIS6jqJfb4E" crossorigin="anonymous">
    <title>Futsal - Réservation</title>
    <link rel="stylesheet" href="../../public/css/styles.css">
</head>
<body>
    
    <!-- HEADER -->

    <header class="header">

    <?php include ('../common/header.php'); ?>

    </header>

    <!-- MAIN -->

    <main>

        <div class="center">
            
            <h1>Réservation</h1>
            <p class="warning">Vous pouvez réserver un créneau d'une heure maximum.</p>
            
            <form method="POST">
                
                <div class="txt_field">
                    <input type="text" name="titre" placeholder="Titre la réservation" required autocomplete="off">

                    </div>

                    <div class="txt_field">
                        <input type="date" name="date" required autocomplete="off">  
                    </div>

                    <div class="heure">
                    
                    <label for="heureDebut"></label>
                    <select name="heureDebut">
                            <option value="08:00:00">08:00h</option>
                            <option value="09:00:00">09:00h</option>
                            <option value="10:00:00">10:00h</option>
                            <option value="11:00:00">11:00h</option>
                            <option value="12:00:00">12:00h</option>
                            <option value="13:00:00">13:00h</option>
                            <option value="14:00:00">14:00h</option>
                            <option value="15:00:00">15:00h</option>
                            <option value="16:00:00">16:00h</option>
                            <option value="17:00:00">17:00h</option>
                            <option value="18:00:00">18:00h</option>
                        </select>

                        <select name="heureFin">
                            <option value="09:00:00">09:00h</option>
                            <option value="10:00:00">10:00h</option>
                            <option value="11:00:00">11:00h</option>
                            <option value="12:00:00">12:00h</option>
                            <option value="13:00:00">13:00h</option>
                            <option value="14:00:00">14:00h</option>
                            <option value="15:00:00">15:00h</option>
                            <option value="16:00:00">16:00h</option>
                            <option value="17:00:00">17:00h</option>
                            <option value="18:00:00">18:00h</option>
                            <option value="19:00:00">19:00h</option>
                        </select>
                </div>

              
                <textarea  name="description" placeholder="Description la réservation" required autocomplete="off"></textarea>


                <input type="submit" name="formsend" value="Réserver">
                <div class="signup_link">
                <p>Vous souhaitez voir nos disponibilités ?</p><br>
                <a href="connexion.php">Voir le planning ici.</a>

                <?php

                // Vérification si le formulaire a été envoyé

                $id_utilisateur = $_SESSION['id'];
       
                if(isset($_POST) AND !empty($_POST) ) {

                // Empêcher les failles XSS

            $titre = htmlspecialchars($_POST['titre']);
            $description = htmlspecialchars($_POST['description']); 
            $date = $_POST['date'];

            $heureDebut = $_POST['heureDebut'];
            $heureFin = $_POST['heureFin'];

            $debut = $date . ' ' . $heureDebut;
            $fin = $date . ' ' . $heureFin;


                
        $heureFinSecond = strtotime($heureFin);
        $heureDebutSecond = strtotime($heureDebut);
                

        $res = $heureDebutSecond - $heureFinSecond;
        $res1 = (int) $heureDebut - (int) $heureFin;


        $message = null;

        $timestampdebut = (int) strtotime($debut);
        $timestampfin = (int) strtotime($fin);
        $today = date("Y-m-d H:i:s");
        // $heureActuelle = date("H:i:s");
        $DateAndTime = intval(strtotime($today));

        $check = $db->prepare('SELECT * FROM reservations WHERE debut = ?');
        $check->execute(array($debut));
        $data = $check->fetch();
        $row = $check->rowCount();

                // si je jour et l'heure de début est depassé

                if ( $DateAndTime < $timestampdebut ) {
                        
                    if ($row == 0) {

                            if ($res < 0 ) {

                                 if ($res1 == -1) {
                                
                                $date1 = strtotime($date); 
                                $date2 = date("l", $date1); 
                                $date3 = strtolower($date2);

                                if($date3 == "saturday"  || $date3 == "sunday"){

                                    echo '<div class= "error_php">' ."Le créneau est indisponible. " . '</br>';
                                
                            
                                }

                                else {

                                    // Si réservation réussie

                                    $insert = $db->prepare ('INSERT INTO reservations (titre, description, debut, fin, id_utilisateur) VALUES (:titre, :description, :debut, :fin, :id_utilisateur)');
                                    $insert->execute(array('titre' => $titre, 'description' => $description,'debut' => $debut,'fin' => $fin, 'id_utilisateur' => $id_utilisateur));
                                    
                                    echo '<div class= "success_php">' ."La réservation a été enregistrée avec succès." . '</br>';

                                }
                            }
                                

                        else { 
                             
                            echo '<div class= "error_php">' . "Le créneau ne doit pas dépasser une heure." . '</br>';
                            
                        }
                    }
                    

                    else { 

                        echo '<div class= "error_php">' . "Le créneau est incorrect." . '</br>';
                    }
                }


                        else {

                            echo '<div class= "error_php">' ."Le créneau a déjà été réservé." . '</br>';

                         }
                  }
        
                
            else {

                echo '<div class= "error_php">' ."Date dépassée." . '</br>';

            }
        }
        
    
            

            ?>

                </div>
            
            </form>

        </div>

    </main>

    <!-- FOOTER -->

    <footer>

    <?php include ('../common/footer.php'); ?>

    </footer>

</body>
</html>
