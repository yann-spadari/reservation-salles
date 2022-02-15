<?php

session_start();

require '../common/config.php';


$req = $db->prepare("SELECT utilisateurs.login, titre, description,DATE_FORMAT(debut,'%H:%i') as 'debut', DATE_FORMAT(fin,'%H:%i') as 'fin' FROM reservations INNER JOIN utilisateurs ON reservations.id_utilisateur = utilisateurs.id");
//$resultat = $req->fetchAll(PDO::FETCH_ASSOC);
$req->execute(array());

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/styles.css">
    <title>Reservation</title>
</head>
<body>
    
        <!-- HEADER -->

        <header class="header">

            <?php include ('../common/header.php '); ?>

        </header>

        <main>

            <section>

                <?php while($data = $req->fetch(PDO::FETCH_ASSOC)): ?>


                    <p>nom :<?= $data['login'] ?></p>
                    <p>titre de l'évenement :<?= $data['titre'] ?></p>
                    <p>description :<?= $data['description'] ?></p>
                    <p>Heure de début:<?= $data['debut'] ?></p>
                    <p>Heure de fin :<?= $data['fin'] ?></p>
                <?php endwhile; ?>
            </section>

        </main>

        <!-- FOOTER -->

        <footer>

            <?php include ('../common/footer.php'); ?>

        </footer>
</body>
</html>