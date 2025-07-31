<?php

session_start();

require_once('crud.php');

date_default_timezone_set('Europe/Paris');

addsujet();

$sujets = sujetlist();


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style6.css">
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

            <div class="behind">
                <div class="topsujet">
                    <p>SUJETS</p>
                    <div class="topsujetright">
                        <p>RÉPONSES</p>
                        <p>CREATEUR</p>
                    </div>
                </div>
                <div class="allsujet">
                    <?php foreach ($sujets as $sujet): ?>
                        
                        <div class="sujet">
                            
                            <div class="nom">
                                <a href="sujet.php?id=<?= $sujet['sujet_id'] ?>"><?= $sujet['nom'] ?></a>
                            </div>
                            <div class="sujetright">
                                <div class="reponses">
                                    <p><?= $sujet['reponses'] ?></p>
                                </div>
                                <div class="lastmess">
                                    <p>Par <?= $sujet ['pseudo']?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>


        </main>








        <footer>

            <?php if (isset($_SESSION['id'])): ?>
                <div class="addsujet">
                    <p>Voulez vous ajoutez un sujet de discussion?</p>
                    <form action="" method="post">
                        <input type="texte" name="nom" placeholder="Nom du sujet" required>
                        <button>Ajoutez</button>
                    </form>
                </div>
            <?php else : ?>
                <p>Veuillez <a href="login.php">vous connecter</a> pour ajoutez un sujet</p>
            <?php endif ?>
        </footer>

    </div>
</body>

</html>