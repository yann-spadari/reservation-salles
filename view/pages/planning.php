<?php require '../common/config.php';

// Récuperation des variables passées, on donne soit année; mois; année+mois
if(!isset($_GET['mois'])) {

	$num_mois = date("n");

} else {

	$num_mois = $_GET['mois'];
}

if(!isset($_GET['annee'])) {

	$num_an = date("Y");
	
} else {

	$num_an = $_GET['annee'];
}

// pour pas s'embeter a les calculer a l'affichage des fleches de navigation...
if($num_mois < 1) {

	$num_mois = 12; $num_an = $num_an - 1;

} elseif($num_mois > 12) {

	$num_mois = 1; $num_an = $num_an + 1; 
}

// tableau des jours, tableau des mois...
$tab_jours = array("","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche");
$tab_mois = array("","Janvier","Fevrier","Mars","Avril","Mai","Juin","Juillet","Aout","Septembre","Octobre","Novembre","Decembre");

// nombre de jours dans le mois et numero du premier jour du mois
$premier_jour = date(mktime(0,0,0,$num_mois,1,$num_an));
$nombre_jour_mois = cal_days_in_month(CAL_GREGORIAN,$num_mois,$num_an);

echo $nombre_jour_mois;


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

		<table>
			<tr>
				<td><a href="planning.php?mois=<?php echo $num_mois-1; ?>&amp;annee=<?php echo $num_an; ?>"><<</a>&nbsp;&nbsp;<?php echo $tab_mois[$num_mois];  ?>&nbsp;&nbsp;<a href="planning.php?mois=<?php echo $num_mois+1; ?>&amp;annee=<?php echo $num_an; ?>">>></a></td>
			</tr>
			<tr>
				<td><a href="planning.php?mois=<?php echo $num_mois; ?>&amp;annee=<?php echo $num_an-1; ?>"><<</a>&nbsp;&nbsp;<?php echo $num_an;  ?>&nbsp;&nbsp;<a href="planning.php?mois=<?php echo $num_mois; ?>&amp;annee=<?php echo $num_an+1; ?>">>></a></td>
			</tr>
		</table>

	</main>

	<!-- FOOTER -->
	<footer>

		<?php include ('../common/header.php'); ?>

	</footer>
</body>
</html>