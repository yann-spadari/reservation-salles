<nav>
  
  <a class="logo" href="accueil.php">CineKing</a>

  <ul>
    
    <?php if(isset($_SESSION['id'])) : ?>
      
      <li><a href="planning.php">Planning</a></li>
      <li><a href="reservation.php">Réservation</a></li>
      <li><a href="profil.php">Profil</a></li>
      <li><a href="../common/deconnexion.php">Déconnexion</a></li>

    <?php else : ?>
        
      <li><a href="inscription.php">Inscription</a></li>
      <li><a href="connexion.php">Connexion</a></li>

    <?php endif ?>

  </ul>
</nav>