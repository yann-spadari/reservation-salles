<?php

// ------------------------------------------
// TRAITEMENT DE LA CONNEXION <<<<<<<<<<<<<<<
// ------------------------------------------

// Démarrage de la session

session_start();

// Connexion à la base de donnée

require '../common/config.php'; 

// Checker si l'utilisateur est déjà connecté ou pas

if (isset($_SESSION['id'])) {

    // On redirige vers l'accueil

    header('Location:accueil.php');

}

?>

<!--Création du formulaire de connexion-->

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css" integrity="sha384-i1LQnF23gykqWXg6jxC2ZbCbUMxyw5gLZY6UiUS98LYV5unm8GWmfkIS6jqJfb4E" crossorigin="anonymous">
    <title>Futsal - Connexion</title>
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
            
            <h1>Connexion</h1>
            
            <form method="post">
                <div class="txt_field">
                    <input type="text" name="login" placeholder="Nom d'utilisateur" required autocomplete="off">
                </div>
              
                <div class="txt_field">
                    <input type="password" name="password" placeholder="Mot de passe" required autocomplete="off">
                </div>
            
                <div class="pass">Mot de passe oublié ?</div>
                    <input type="submit" name="formsend" value="Se connecter">
                    <div class="signup_link">
                    <p>Vous n'avez pas de compte ?</p><br>
                     <a href="inscription.php">Inscrivez-vous ici.</a>


<?php

// Vérification si le formulaire a été envoyé

if(isset($_POST) AND !empty($_POST) ) {
  
  // Vérification si les champs existent et si ils sont bien remplis

  if (!empty($_POST['login']) && !empty($_POST['password'])){

    // Empêcher les failles XSS

    $login=htmlspecialchars($_POST['login']);
    $password=htmlspecialchars($_POST['password']);

    // Checker si le compte est présent dans la table

    $check = $db->prepare('SELECT * FROM utilisateurs WHERE login = ?');
    $check->execute(array($login));
    $data = $check->fetch();
    $row = $check->rowCount();

    // Si le compte existe

    if ($row > 0) {

      // Si le mot de passe est correct

      if (password_verify($password, $data['password'])) {

        // Création de la session Membre puis redirection vers profil.php
      
        $_SESSION['id'] = $data['id'];
        $_SESSION['login'] = $data['login'];
        $_SESSION['email'] = $data['email'];
        $_SESSION['password'] = $data['password'];
            
        header('Location:accueil.php?id=' . $_SESSION['id']);
        // DEBUG => echo 'Bonjour' . ' ' . $data['prenom'];

      }
          
      
      
      else { 
          
        // Si le mot de passe ne correspond pas

        echo '<div class= "error_php">' . "Mot de passe incorrect." . '</div>';
      
      }

    }
      
    else { 
        
      // Si le compte est inexistant dans la table

      echo '<div class= "error_php">' . "Le compte n'existe pas." . '</div>';
          
    }
  }

  else { 

    // Retour sur connexion.php si le formulaire est vide
    
    header('Location: connexion.php'); 
    
    die();

  } 

}

?>
            
                </div>
            
            </form>
        </div>

    </main>

    <!--IMPORT DU FOOTER -->

    <footer>

    <?php include ('../common/footer.php'); ?>

    </footer>

</body>
</html>