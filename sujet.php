<?php

session_start();

require_once('crud.php');

date_default_timezone_set('Europe/Paris');

$sujets = sujetlist();

$sujetscomm = sujetcomm();

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
        





        </main>
