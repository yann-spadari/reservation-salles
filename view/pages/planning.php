<?php 

require_once '../common/config.php';

session_start();

if(isset($_SESSION['login'])){
    
    $user = $_SESSION['login'];
    
    $req = $db->prepare("SELECT titre, DATE_FORMAT(fin, '%w'), DATE_FORMAT(debut,'%T'), DATE_FORMAT(fin,'%T'),utilisateurs.login, reservations.id , DATE_FORMAT(debut, '%d') FROM reservations INNER JOIN utilisateurs ON reservations.id_utilisateur = utilisateurs.id WHERE week(reservations.debut) = WEEK(CURDATE())");
    $req->execute();
    $result = $req->fetchAll();
}

$jour = date("w"); // numéro du jour actuel

if (isset($_GET['jour'])) {
    $jour = ($_GET['jour']);
}
 
if (!empty($_GET['week']) && ($_GET['week'] == "pre")) { // Si on veut afficher la semaine précédente
	
    $jour = $jour + 7;
}
else if (!empty($_GET['week']) && ($_GET['week'] == "next")) { // Si on veut afficher la semaine suivante

    $jour = $jour - 7;
}
 
$nom_mois = date("F"); // nom du mois actuel
$annee = date("Y"); // année actuelle

$nom_mois = date("F", mktime(0,0,0,date("n"),date("d")-$jour+1,date("y")));
$annee = date("Y", mktime(0,0,0,date("n"),date("d")-$jour+1,date("y")));
$num_week = date("W", mktime(0,0,0,date("n"),date("d")-$jour+1,date("y")));
 
$dateDebSemaine = date("Y-m-d", mktime(0,0,0,date("n"),date("d")-$jour+1,date("y")));
$dateFinSemaine = date("Y-m-d", mktime(0,0,0,date("n"),date("d")-$jour+7,date("y")));
     
$dateDebSemaineFr = date("d/m/Y", mktime(0,0,0,date("n"),date("d")-$jour+1,date("y")));
$dateFinSemaineFr = date("d/m/Y", mktime(0,0,0,date("n"),date("d")-$jour+7,date("y")));


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
		<?php

		echo '<div>
				<a href="planning.php?week=pre&jour='.$jour.'"><<</a> Semaine '.$num_week.' <a href="planning.php?week=next&jour='.$jour.'">>></a><br />
					du '.$dateDebSemaineFr.' au '.$dateFinSemaineFr.'
			</div>';

		?>

					
			<section class="planning">
				
				<?php
			
				$tab_jours = array('', 1 => 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi');
				$tab_jour_num = array('', 1 => '1', '2', '3', '4', '5');
			
				$nom_mois = date('M');
			
				echo '<br/>
				<section>

				<div><strong>' . $nom_mois . ' ' . date('Y') . '</strong></div>';
			
				echo '<table>';

			echo '<tr>';
			
			for ($k = 0; $k < 6; $k++) {
				if ($k == 0)
					echo '<th>' . $tab_jours[$k] . '</th>';
				else
					echo '<th><div>' . $tab_jours[$k] . ' ' . date("d", mktime(0, 0, 0, date("n"), date("d") - $jour + $k, date("y"))) . ' ' . $nom_mois . '</div></th>';
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
					$value[6] =  date("d:m:Y");
 			
					if ($value[2] == $h && $value[1] == $tab_jour_num[$j]) {

						//var_dump($value[6]);
			
						$resa = 1;
			
						echo '<div class="reserver">';
						echo 'Titre :' . $value[0] . '</br>';
						echo 'De ' . $value[2] . ' à ' . $value[3] . ' H </br>';
						echo 'Créateur : ' . $value[4] . '</br>';
			
						if (isset($_SESSION["user"])) {
							echo ' <a href = "reservation.php?id=' . $value[5] . '">Réservation</a></td>';
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
				echo '</div></section>';
			
				?>
			
			</section>
		
		
		</main>
		
        <!-- FOOTER -->
        <footer>

            <?php include ('../common/footer.php'); ?>

        </footer>
</body>
</html>

