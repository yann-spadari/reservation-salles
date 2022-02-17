<?php

// ----------------------------
// PAGE ACCUEIL <<<<<<<<<<<<<<<
// ----------------------------

session_start();

require '../common/config.php';

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../public/css/styles.css" />
    <title>Futsal - Accueil</title>
</head>
<body>
    <header>
        <?php require '../common/header.php'; ?>
    </header>

    <main>

    <div class="text">

    <h1>Futsal</h1>

    <img src="../../public/img/futsal.jpg"></img>

    <h2>Bienvenue sur notre site de réservation en ligne de foot en salle.</h2>

    <p> Vous souhaitez réserver un créneau?<p>

    <?php if (isset($_SESSION['id'])) : ?>

        <a href="reservation-form.php">Par ici.</a>

        <?php else : ?>

            <a href="connexion.php">Par ici.</a>

            <?php endif ?>

</div>

    </main>

    <footer>
        <?php require '../common/footer.php'; ?>
    </footer>
</body>
</html>