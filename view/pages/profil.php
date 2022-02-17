<?php

// ---------------------------------------------
// TRAITEMENT DE L'ESPACE MEMBRE <<<<<<<<<<<<<<<
// ---------------------------------------------

// Démarrage de la session

session_start();

// Connexion à la base de donnée

require '../common/config.php';

?>

<?php

// Vérification si l'utilisateur s'est connecté correctement

if (!isset($_SESSION['id']))
{
    header('Location:index.php?connexion_error');

}

?>

<?php

// Checker si le compte est présent dans la table

$check = $db->prepare('SELECT * FROM utilisateurs WHERE id= ?');
$check->execute(array($_SESSION['id']));
$data = $check->fetch();
$row = $check->rowCount();

?>

<!--Création du formulaire d'update du profil de l'utilisateur-->

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css" integrity="sha384-i1LQnF23gykqWXg6jxC2ZbCbUMxyw5gLZY6UiUS98LYV5unm8GWmfkIS6jqJfb4E" crossorigin="anonymous">
    <title>Futsal - Profil</title>
    <link rel="stylesheet" href="../../public/css/styles.css">
</head>
<body>

        <!-- IMPORT DU HEADER -->

        <header class="header">

        <?php include ('../common/header.php'); ?>

        </header>

        <main>
            
            <div class="center">
                
                <h1>Mon Profil</h1>
                <p class="warning">Changer son mot de passe entraînera une déconnexion.</p>
                
                <form method="post">
                    
                    <div class="txt_field">
                        <input type="text" name="login" autocomplete="off" placeholder="Nom d'utilisateur" value=<?php echo $data['login']; ?>>
                        <span></span>
                        
                    </div>
                
                    <div class="txt_field">
                        <input type="password" name="current_password" placeholder="Mot de passe actuel" required autocomplete="off">
                    </div>

                    <div class="txt_field">
                        <input type="password" name="password" placeholder="Nouveau mot de passe" autocomplete="off">
                    </div>

                    <div class="txt_field">
                        <input type="password" name="cpassword" placeholder="Confirmation du mot de passe"autocomplete="off">
                    </div>
                
                    <input type="submit" name="formsend" value="Sauvegarder">
            
                <?php

    if(isset($_POST) AND !empty($_POST) ) { 

        // Empêcher les failles XSS

        $login = htmlspecialchars($_POST['login']);
        $current_password = htmlspecialchars($_POST['current_password']);
        $password = htmlspecialchars($_POST['password']);
        $cpassword = htmlspecialchars($_POST['cpassword']);
        
        // Si le mot de passe actuel est correct

        if (password_verify($current_password, $_SESSION['password'])) { 
            
            if ($_POST['login'] !== $data['login']) {

                // Mise à jour des données entrées par l'utilisateur

                $update = $db->prepare("UPDATE utilisateurs SET login= ? WHERE id = ?");
                $update->execute(array($_POST['login'], $_SESSION['id']));

                // Si mise à jour 'Login' réussie

                echo '<div class= "success_php">' . "Vos données ont été modifiées." . "</br>" . '</div>';
                
                header("Refresh:3");
            }

            else {

                // Si les champs sont restés inchangés

                echo '<div class= "error_php">' . "Vos données n'ont pas été modifiées." . "</br>" .'</div>';

            }
        
            // Si l'utilisateur a décidé de changer son mot de passe
                
            if(isset($_POST['password']) && !empty($_POST['password'])) {

                // Si le nouveau mot de passe est différent de l'ancien

                if ($password != $current_password) {

                    // Si les deux nouveaux mots de passe entrés sont identiques
        
                    if ($password == $cpassword) {

                    // Hashage du mot de passe

                    $cost = ['cost' => 12];
                    $password = password_hash($password, PASSWORD_BCRYPT, $cost);
                

                    // Mise à jour du mot de passe entré par l'utilisateur
                
                    $update = $db->prepare("UPDATE utilisateurs SET password = :password WHERE id = :id");
                    $update->execute(array('password' => $password, 'id' => $_SESSION['id']));

                    $password = $_POST['password'];

                    // Si mise à jour 'Mot de passe' réussie

                    // echo '<div class= "success_php">' . "Votre mot de passe a été modifié." . '</div>';
                    
                    header('Location: ../../view/common/deconnexion.php?');
                    die();

                    }

                    else {

                        // Si les nouveaux mots de passe ne sont pas identiques
            
                        echo '<div class= "error_php">' . "Les mots de passe ne sont pas identiques." . '</div>';


                    }

                }

                else {

                    
                    // Si le nouveau mot de passe est identique au mot de passe actuel
                    
                    echo '<div class= "error_php">' .  "Le nouveau mot de passe est identique au mot de passe actuel." . '</div>';

                }


            }

            else {

                echo '<div class= "error_php">' . "Votre mot de passe n'a pas été modifié." . '</div>'; 

            }

        }

        else {

        // Si le mot de passe ne correspond pas
        
        echo '<div class= "error_php">' . "Mot de passe incorrect." . '</div>';

        }

    }

    ?>

        <br>
        <br>

            </form>
    </div>
        </div>

    <?php

    if(isset($_POST) AND !empty($_POST) ) { 

        // Empêcher les failles XSS

        $login = htmlspecialchars($_POST['login']);
        $current_password = htmlspecialchars($_POST['current_password']);
        $password = htmlspecialchars($_POST['password']);
        $cpassword = htmlspecialchars($_POST['cpassword']);
        
        // Si le mot de passe actuel est correct

        if (password_verify($current_password, $_SESSION['password'])) { 
            
            if ($_POST['login'] !== $data['login'] || $_POST['email'] !== $data['email']) {

                // Mise à jour des données entrées par l'utilisateur

                $update = $db->prepare("UPDATE utilisateurs SET login= ? WHERE id = ?");
                $update->execute(array($_POST['login'], $_SESSION['id']));

                // echo '<div class= "success_php">' . "Vos données ont été modifiées." . "</br>" . '</div>';
                
                echo '<div class= "success_php">' . "Vos données ont été modifiées." . "</br>" . '</div>';

            }

            else {

                // Si les champs sont restés inchangés

                echo '<div class= "error_php">' . "Vos données n'ont pas été modifiées." . "</br>" .'</div>';

            }
        
            // Si l'utilisateur a décidé de changer son mot de passe
                
            if(isset($_POST['password']) && !empty($_POST['password'])) {

                // Si le nouveau mot de passe est différent de l'ancien

                if ($password != $current_password) {

                    // Si les deux nouveaux mots de passe entrés sont identiques
        
                    if ($password == $cpassword) {

                    // Hashage du mot de passe

                    $cost = ['cost' => 12];
                    $password = password_hash($password, PASSWORD_BCRYPT, $cost);
                

                    // Mise à jour du mot de passe entré par l'utilisateur
                
                    $update = $db->prepare("UPDATE utilisateurs SET password = :password WHERE id = :id");
                    $update->execute(array('password' => $password, 'id' => $_SESSION['id']));

                    $password = $_POST['password'];

                    // Si mise à jour 'Mot de passe' réussie

                    echo '<div class= "success_php">' . "Votre mot de passe a été modifié." . '</div>';
                    
                    header('Refresh:3');
                    die();

                    }

                    else {

                        // Si les nouveaux mots de passe ne sont pas identiques
            
                        echo '<div class= "error_php">' . "Les mots de passe ne sont pas identiques." . '</div>';


                    }

                }

                else {

                    
                    // Si le nouveau mot de passe est identique au mot de passe actuel
                    
                    echo '<div class= "error_php">' .  "Le nouveau mot de passe est identique au mot de passe actuel." . '</div>';

                }


            }

            else {

                echo '<div class= "error_php">' . "Votre mot de passe n'a pas été modifié." . '</div>'; 

            }

        }

        else {

        // Si le mot de passe ne correspond pas
        
        echo '<div class= "error_php">' . "Mot de passe incorrect." . '</div>';

        }

    }

    ?>

    </main>

<!--IMPORT DU FOOTER -->

<footer>

<?php include ('../common/footer.php'); ?>

</footer>

</body>
</html>