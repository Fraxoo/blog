<?php

session_start();

require_once('crud.php');

date_default_timezone_set('Europe/Paris');

$sujets = sujetlist();

addcomm();

$sujetscomms = sujetcomm();



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style7.css">
    <title>Fablog3D</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
</head>


<body>

    <div class="all">
        <header>

            <div class="haut">
                <div class="hautgauche">
                    <img src="images/pngegg.png">
                    <h1><a href="index.php">Fablog3D</a></h1>
                </div>
                <div class="hautdroite">

                    <input type="search">
                    <button><img src="images/search(1).png"></button>

                    <a href="upload.php">UPLOAD</a>
                    <a href="group.php">Discussion</a>
                    <?php if (!isset($_SESSION['id'])): ?>
                        <a href="login.php">Se Connecter</a>
                    <?php else : ?>
                        <a href="account.php">Mon Compte</a>
                    <?php endif ?>
                </div>
            </div>

        </header>

        <main>

            <div class="mid">

                <div class="retour">
                    <a href="group.php">Retour</a>
                </div>

            </div>

            <div class="comm">
            <?php foreach ($sujetscomms as $sujetscomm) : ?>

                <div class="behind">
                    <div class="auteur">
                        <p>Poster par <?=$sujetscomm['pseudo']?></p>
                    </div>

                    <div class="commentaire">
                        <p>Poster le <?= $sujetscomm['date']?> a <?=$sujetscomm['heure']?></p>
                        <p><?= $sujetscomm['commentaire']?></p>
                    </div>
                </div>
            <?php endforeach ?>
                    
            </div>
        </main>

        <footer>

            <?php if (isset($_SESSION['id'])): ?>
                <div class="addsujet">
                    <p>Voulez vous ajoutez un commentaire?</p>
                    <form action="" method="post">
                        <input type="texte" name="commentaire" placeholder="Commentaire :" required>
                        <button>Ajoutez</button>
                    </form>
                </div>
            <?php else : ?>
                <p>Veuillez <a href="login.php">vous connecter</a> pour ajoutez un commentaire</p>
            <?php endif ?>
        </footer>


    </div>




    </main>