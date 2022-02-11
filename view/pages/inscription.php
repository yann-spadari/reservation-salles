<?php

session_start();

// -------------------------------------------
// TRAITEMENT DE L'INSCRIPTION <<<<<<<<<<<<<<<
// -------------------------------------------

// Connexion à la base de donnée

require '../common/config.php';

// Checker si l'utilisateur est déjà connecté ou pas

if (isset($_SESSION['id'])) {

    // On redirige vers l'accueil

    header('Location:accueil.php');

}

?>

<!--Création du formulaire d'inscription-->

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css" integrity="sha384-i1LQnF23gykqWXg6jxC2ZbCbUMxyw5gLZY6UiUS98LYV5unm8GWmfkIS6jqJfb4E" crossorigin="anonymous">
    <title> - Inscription</title>
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
            
            <h1>Inscription</h1>
            
            <form method="post">
                
                <div class="txt_field">
                    <input type="text" name="login" placeholder="Nom d'utilisateur" required autocomplete="off">

                </div>
              
                <div class="txt_field">
                    <input type="password" name="password" placeholder="Mot de passe" required autocomplete="off">

                </div>

                <div class="txt_field">
                    <input type="password" name="cpassword" placeholder="Confirmation du mot de passe" required autocomplete="off">
                </div>
            
                    <input type="submit" name="formsend" value="S'inscrire">
                    <div class="signup_link">
                    <p>Vous avez déjà un compte ?</p><br>
                     <a href="connexion.php">Connectez-vous ici.</a>

                    <?php

                    // Vérification si le formulaire a été envoyé
                    
                    if(isset($_POST) AND !empty($_POST) ) {
                    
                    // Empêcher les failles XSS
                    
                    $login = htmlspecialchars($_POST['login']);
                    $password = htmlspecialchars($_POST['password']);
                    $cpassword = htmlspecialchars($_POST['cpassword']);
                    
                    // Checker si le nom d'utilisateur existe
                    
                    $check_user = $db->prepare('SELECT login FROM utilisateurs WHERE login = ?');
                    $check_user->execute(array($login));
                    $data_user = $check_user->fetch();
                    $row_user = $check_user->rowCount();
                    
                    // Si le nom d'utilisateur n'existe pas
                    
                    if ($row_user == 0) {
                    
                            // Si les deux mots de passe sont identiques
                        
                            if ($password == $cpassword) {
                    
                            // Hashage du mot de passe
                    
                            $cost= ['cost' => 12];
                            $password = password_hash($password, PASSWORD_BCRYPT, $cost);
                    
                            // Insertion des données entrées par l'utilisateur dans la table
                    
                            $insert = $db->prepare ('INSERT INTO utilisateurs(login, password) VALUES (:login, :password)');
                            $insert->execute(array('login' => $login, 'password' => $password));
                    
                            // Si inscription réussie
                    
                            $_SESSION['id'] = $data_user['id'];
                    
                            // echo '<div class= "success_php">' ."L'inscription a été effectué avec succès." . '</br>' . "Vous pouvez vous connecter " . '<a style= "color: #337BD4" href="connexion.php">' . "ici" . '</a>' . '</div>';
                            header('Location:connexion.php' . $_SESSION['id']);
                            
                    
                            }
                    
                            else {
                    
                            // Si les mots de passes ne correspondent pas
                    
                            echo '<div class= "error2_php">' ."Les mots de passe ne sont pas identiques." . '</div>';
                    
                            }
                    
                        }
                    
                        else {
                    
                            // Si le login entré par l'utilisateur existe déjà dans la base de donnée
                            
                            echo '<div class= "error2_php">' ."Le nom d'utilisateur est déjà utilisé." . '</div>';
                    
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