<?php

session_start();

require_once('crud.php');

$bdd = connect();

$get = $bdd->prepare('SELECT * FROM user INNER JOIN post ON user.id = post.userid WHERE userid = :userid');
$get->execute([
    'userid' => $_SESSION['id']
]);
$posts = $get->fetchAll();






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
            <p>Mes model en ligne :</p>

            <?php foreach ($posts as $post): ?>
                <div class="post">
                    <p><?= $post['nom']?></p>
                    <p><?= $post['id']?></p>
                    <a href="removeproduct.php?id=<?= $post['id']?>">Supprimer</a>
                </div>

            <?php endforeach ?>

            <a class="deco" href="logout.php">Se Deconnecter</a>

        </div>

        




    </main>




</body>

</html>