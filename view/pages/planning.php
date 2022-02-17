<?php 

require '../common/config.php';

session_start();

$jour = date("w"); // numéro du jour actuel
$nom_mois = date("F"); // nom du mois actuel
$annee = date("Y"); // année actuelle
$num_week = date("W"); // numéro de la semaine actuelle

$dateDebSemaineFr = date("d/m/Y", mktime(0,0,0,date("n"),date("d")-$jour+1,date("y")));
$dateFinSemaineFr = date("d/m/Y", mktime(0,0,0,date("n"),date("d")-$jour+7,date("y")));
 
$jourTexte = array('',1=>'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
$jourNum = array('', 1 => '1', '2', '3', '4', '5');

if(isset($_SESSION['login'])){
    
    $user = $_SESSION['login'];
    
    $req = $db->prepare("SELECT titre, DATE_FORMAT(fin, '%w'), DATE_FORMAT(debut,'%T'), DATE_FORMAT(fin,'%T'),utilisateurs.login, reservations.id FROM reservations INNER JOIN utilisateurs ON reservations.id_utilisateur = utilisateurs.id WHERE week(reservations.debut) = WEEK(CURDATE()) AND utilisateurs.id = :id ");
    $req->execute(array('id' => $_SESSION['id']));
    $result = $req->fetchAll();

} else {
	$req = $db->prepare("SELECT titre, DATE_FORMAT(fin, '%w'), DATE_FORMAT(debut,'%T'), DATE_FORMAT(fin,'%T'),utilisateurs.login, reservations.id FROM reservations INNER JOIN utilisateurs ON reservations.id_utilisateur = utilisateurs.id WHERE week(reservations.debut) = WEEK(CURDATE())");
    $req->execute();
    $result = $req->fetchAll();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../../public/css/styles.css">
	<title>Planning</title>
</head>
<body>

        <!-- HEADER -->

        <header class="header">

            <?php include ('../common/header.php '); ?>

        </header>
     
		<main>
				
			<section class="planning">

			<?php
			
			echo '<br/>
			<div id="titreMois" align="center">
				<h2>'.$nom_mois.' '.$annee.'</h2>
			</div>';
			
			echo '<table border="1" align="center">';
			
				// en tête de colonne
				echo '<tr>';
				for($k = 0; $k < 6; $k++) {
					if($k==0)
						echo '<th>'.$jourTexte[$k].'</th>';
					else
						echo '<th><div>'.$jourTexte[$k].' '.date("d", mktime(0,0,0,date("n"),date("d")-$jour+$k,date("y"))).'</div></th>';
					
				}
				echo '</tr>';
			

				for ($h = 8; $h <= 18; $h++) {
					echo '<tr>
					<th>
						<div>'. $h.'h00 - '.($h+1).'h00'. '</div>
					</th>';
				
					// affichage planning jour
					for ($j = 1; $j < 6; $j++) {
						echo '<td>';
				
					$resa = 0;
				
						foreach ($result as $value) {

							//var_dump($result);
					
							$value[2] =  date("H:i", strtotime($value[2]));
							$value[3] =  date("H:i", strtotime($value[3]));

							

							if ($value[2] == $h && $value[1] == $jourNum[$j]) {
					
								$resa = 1;

								//var_dump($value[5]);

								echo '<a href = "evenement.php?id=' . $value[5] . '">';
								echo '<div class="reserver">';
								echo 'Titre :' . $value[0] . '</br>';
								echo 'Créateur : ' . $value[4] . '</br>';
								echo '</a>';
					
								if (isset($_SESSION["id"])) {
									echo ' <a href = "evenement.php?id=' . $value[5] . '">Réservation</a></td>';
								}
					
								echo '</div>';
							}
						}
						if ($resa == 0) {
							echo '<a href="reservation-form.php">Disponible</a>';
						}
						echo '</td>';
					}
				'</tr>';
				}
			echo '</table>';
			?>
			</section>

		
		
		</main>
		
        <!-- FOOTER -->
        <footer>

            <?php include ('../common/footer.php'); ?>

        </footer>
</body>
</html>
