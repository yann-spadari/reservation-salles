<?php 

require_once '../common/config.php';

session_start();

if(isset($_SESSION['login'])){
    
    $user = $_SESSION['login'];
    
    $req = $db->prepare("SELECT titre, DATE_FORMAT(fin, '%w'), DATE_FORMAT(debut,'%T'), DATE_FORMAT(fin,'%T'),utilisateurs.login, reservations.id FROM reservations INNER JOIN utilisateurs ON reservations.id_utilisateur = utilisateurs.id WHERE week(reservations.debut) = WEEK(CURDATE())");
    $req->execute(array());
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
	<title>Document</title>
</head>
<body>

        <!-- HEADER -->

        <header class="header">

            <?php include ('../common/header.php '); ?>

        </header>
     
		<main>

			<div class="jour">
				<p>
					<?php

					$jour = date("w");
					$dateDebutSemaine = date("d/m/Y", mktime(0, 0, 0, date("n"), date("d") - $jour + 1, date("y")));
					$dateFinSemaine= date("d/m/Y", mktime(0, 0, 0, date("n"), date("d") - $jour + 7, date("y")));
					echo '<div>Semaine du  : ' . $dateDebutSemaine . ' au ' . $dateFinSemaine . ' </div> '; ?>

				</p>
			
			</div>
					
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
			
					$value[2] =  date("H:i", strtotime($value[2]));
					$value[3] =  date("H:i", strtotime($value[3]));
			
					if ($value[2] == $h && $value[1] == $tab_jour_num[$j]) {
			
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

            <?php include ('../common/header.php'); ?>

        </footer>
</body>
</html>

