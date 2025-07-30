<?php

session_start();

require_once('crud.php');

$bdd = connect();

$posts = showpost();

$favoris = showfavorites();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style5.css">
    <title>Fablog3D</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
</head>

<body>
    <?php if(isset($_SESSION['id'])):?>

    <header>

        <div class="haut">

            <div class="hautmid">
                <a href="index.php">Acceuil</a>
            </div>

        </div>

    </header>

    <main>

        <div class="all">
            <h2><?= $_SESSION['pseudo'] ?></h2>

            <div class="model">
                <p>Mes model en ligne :</p>

                <?php foreach ($posts as $post): ?>
                    <div class="post">
                        <p><?= $post['nom'] ?></p>
                        <p><?= $post['id'] ?></p>
                        <a href="removeproduct.php?id=<?= $post['id'] ?>">Supprimer</a>
                    </div>
                <?php endforeach ?>
            </div>


            <div class="favoris">
                <p>Mes Favoris :</p>
                <?php foreach ($favoris as $favori): ?>
                    <div class="post">
                        <p><?= $favori['nom'] ?></p>
                        <p><?= $favori['id'] ?></p>
                        <a href="deletefavoris.php?id=<?= $favori['id'] ?>">Supprimer</a>
                    </div>



                <?php endforeach ?>
            </div>
            <a class="deco" href="logout.php">Se Deconnecter</a>
            <a class="rouge" href="deleteaccount.php">Supprimer le compte</a>

        </div>






    </main>


<?php else :?>

        <?php header('location:index.php')?>

    <?php endif; ?>

</body>

</html>