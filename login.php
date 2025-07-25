<?php

session_start();

require_once('crud.php');

if(isset($_POST['email']) && isset($_POST['password'])){
    login();
    $erreur = login();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
</head>

<header>

    <div class="haut">

        <div class="hautmid">
            <a href="index.php">Acceuil</a>
        </div>

    </div>

</header>

<main>

    <div class="all">

        <div class="formulaire">
            <form action="login.php" method="post">
                <div class="email">
                    <img src="images/email.png" alt="">
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="password">
                    <img src="images/lock.png">
                    <input type="password" name="password" placeholder="Mot de passe" required>
                </div>
                <div class="erreur">
                    <?= $erreur ?>
                </div>
                <button>Se Connecter</button>
            </form>
            <div class="register">
                <p>vous n'avez pas de Compte ? <a href="register.php">S'inscire</a></p>
            </div>
        </div>

    </div>

</main>


</html>