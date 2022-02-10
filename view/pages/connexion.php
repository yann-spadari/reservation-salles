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
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Connexion</title>
<link rel="stylesheet" href="../../public/css/style.css">
<link rel="icon" href="favicon.ico" />
</head>
<body>

<!--Import du header -->

<header>

<?php include ('../common/header.php'); ?>

</header>

<!-- Formulaire -->

<div class="user_login">
    
    <form class="login_form" action="" method="POST">
        
        <h1 class="login_text">Connexion</h1>

        <div class="form_container">
        <input type="text" class="form_input" name="login" placeholder="Nom d'utilisateur" required="required" autocomplete="off">
        </div>
        
        <div class="form_container">
        <input type="password" class="form_input" name="password" placeholder="Mot de passe" required="required" autocomplete="off">
        </div>
        
        <div class="form_container">
        <input type="submit" class="btn" name="formsend" value="Se connecter">
        </div>    

        <p>Vous n'avez pas de compte?</p>
        <p class="login_register_text"><a href="inscription.php"> Inscrivez-vous ici.</a></p>
    
    </form>   

</div>

<?php

// Vérification si le formulaire a été envoyé

if(isset($_POST) AND !empty($_POST) ) {
  
  // Vérification si les champs existent et si ils sont bien remplis

  if (!empty($_POST['login']) && !empty($_POST['password'])){

    // Empêcher les failles XSS

    $login=htmlspecialchars($_POST['login']);
    $password=htmlspecialchars($_POST['password']);

    // Checker si le compte est présent dans la table

    $check = $db->prepare('SELECT id, login, email, password, id_droits FROM utilisateurs WHERE login = ?');
    $check->execute(array($login));
    $data = $check->fetch();
    $row = $check->rowCount();

    // Si le compte existe

    if ($row > 0) {

      // Si le mot de passe est correct

      if (password_verify($password, $data['password'])) {

        // S'il s'agit du compte Administrateur
        
        if ($data['login'] == 'admin') {

          // Création de la session Administrateur puis redirection vers admin.php

          $_SESSION['id'] = $data['id'];

          header('Location:admin.php?id=' . $_SESSION['id']);
          // echo 'Bonjour' . ' ' . $data['prenom'];

        }
        
        // S'il s'agit d'un compte Membre classique

        else {

          // Création de la session Membre puis redirection vers profil.php
        
          $_SESSION['id'] = $data['id'];
          $_SESSION['login'] = $data['login'];
          $_SESSION['email'] = $data['email'];
          $_SESSION['password'] = $data['password'];
          $_SESSION['id_droits'] = $data['id_droits'];
            
          header('Location:accueil.php?id=' . $_SESSION['id']);
          // DEBUG => echo 'Bonjour' . ' ' . $data['prenom'];


          }
          
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

<!--Import du footer -->
 
<footer>

<?php include ('../common/footer.php'); ?>

</footer>

</body>
</html>
