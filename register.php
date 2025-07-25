<?php 

session_start();

require_once('crud.php');

$read = getall();

if(isset($_POST['pseudo']) && isset($_POST['email']) && isset($_POST['password'])){
    $pseudo = $_POST['pseudo'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'],PASSWORD_BCRYPT);
    if(doublepseudo($pseudo)){
        $pseudoerreur = "Pseudo déja utilisée";
    }else{
    if(doubleemail($email)){
        $emailerreur = "Adresse email déja utilisée";
    }else{
        if($_POST['password'] != $_POST['password2']){
        $mdperreur = "Mot de passe incorect";
        }else{
        adduser($pseudo,$email,$password);
        $valid = 'Incription reussi ! Cliquez ici continuez :';
    }
}
}
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

    <?php if(!isset($valid)):?>
    <div class="all">
        <div class="done">

        </div>
        <div class="formulaire">
            <form action="register.php" method="post" >
                <div class="email">
                    <img src="images/tete.png" alt="">
                    <input type="text" name="pseudo" placeholder="Pseudo" required>
                </div>
                <div class="email">
                    <img src="images/email.png" alt="">
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="password">
                    <img src="images/lock.png">
                    <input type="password" name="password" placeholder="Mot de passe" required>
                </div>
                <div class="password">
                    <img src="images/lock.png">
                    <input type="password" name="password2" placeholder="confirmation" required>
                </div>
                <div class="erreur">
                    <?= $pseudoerreur ?>
                    <?= $emailerreur ?>
                    <?= $mdperreur ?>
                </div>
                <button>S'inscrire</button>
            </form>
            <div class="register">
                <p>Vous avez deja un compte ? <a href="login.php">Se connecter</a></p>
            </div>
        </div>

    </div>
    <?php else :?>
        <div class="done">
                <p><?= $valid ?> <a href="login.php">Se Connecter</a></p>
        </div>
    <?php endif; ?>  

</main>


</html>