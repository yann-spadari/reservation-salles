<?php
require '../common/config.php';

session_start();

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
    <title>Futsal - Réservation</title>
</head>
<body>
    
        <!-- HEADER -->

        <header class="header">

            <?php include ('../common/header.php '); ?>

        </header>

        <main>

            <div class="evenement">

            <h1>Evenement</h1>

            <div>

                <?php while($data = $req->fetch(PDO::FETCH_ASSOC)): ?>

                    <table class="reservation">
                        <tr>
                            <th>nom :</th>
                            <th>titre de l'évenement :</th>
                            <th>description :</th>
                            <th>Heure de début:</th>
                            <th>Heure de fin :</th>
                        </tr>

                        <tr>
                            <td><?= $data['login'] ?></td>
                            <td><?= $data['titre'] ?></td>
                            <td><?= $data['description'] ?></td>
                            <td><?= $data['debut'] ?></td>
                            <td><?= $data['fin'] ?></td>
                        </tr>
                    </table>
                <?php endwhile; ?>
                </div>
                </div>

        </main>

        <!-- FOOTER -->

        <footer>

            <?php include ('../common/footer.php'); ?>

        </footer>
</body>
</html>