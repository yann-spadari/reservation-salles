<div class="footer">
<nav>
  
    <ul>
   
        <?php if(isset($_SESSION['id'])) : ?>
        
        <li><a href="profil.php">Profil</a></li>
        <li class="bar_footer">|</li>
        <li><a href="deconnexion.php">Déconnexion</a></li>
        <li class="bar_footer">|</li>
    
        <?php else : ?>
        
        <li><a href="inscription.php">Inscription</a></li>
        <li class="bar_footer">|</li>
        <li><a href="connexion.php">Connexion</a></li>
        <li class="bar_footer">|</li>

        <?php endif ?>
        
        <li><a href="#">Github</a></li>
    
    </ul>

</nav>
</div>