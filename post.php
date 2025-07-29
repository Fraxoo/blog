<?php
session_start();
require_once('crud.php');
date_default_timezone_set('Europe/Paris');

$post = postview();

$bdd = connect();

$date = date('d').'/'.date('m').'/'.date('y');
$heure = date('H').'h'.date('i');

$postid = $_GET['id'];

if(isset($_POST['commentaire'])){
$request = $bdd->prepare('INSERT INTO review (commentaire,date,heure,postid,userid) VALUES (:commentaire, :date, :heure, :postid, :userid)');
$request->execute([
    'commentaire' => $_POST['commentaire'],
    'date' => $date,
    'heure' => $heure,
    'postid' => $postid,
    'userid' => $_SESSION['id']
]);

};

$list = $bdd->prepare('SELECT * FROM review INNER JOIN user ON user.id = review.userid WHERE postid = :postid');
$list->execute([
    'postid' => $postid
]);

$commentaires = $list->fetchall();








?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style4.css">
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
    <?php if(isset($_SESSION['id'])):?>
        <h1><?= $post['nom']?></h1>
        <p>Publier par : <?= $post['pseudo']?></p>
        <div class="container" id="container3D"></div>
        <p><?= $post['description']?></p>
    

    <?php else :?>

        <p>Veuillez <a href="login.php">vous connecter</a> pour voir cette publication</p>

    <?php endif; ?>
    
    </main>

<footer>
    <div class="addcom">
        <h2>Commentaire :</h2>
        <form action="" method="post">
            <input type="text" name="commentaire" placeholder="Ajoutez un commentaire" required>
            <button>Ajoutez</button>
        </form>
    </div>
    
    
        <?php foreach($commentaires as $commentaire):?>
            <div class="com">
                <div class="top">
                <p>Publier par <?= $commentaire['pseudo']?> le <?= $commentaire['date']?> a <?= $commentaire['heure']?></p>
                </div>
                <p><?= $commentaire['commentaire']?></p>
            </div>
        <?php endforeach ?>
    

    

</footer>






    <!-- On injecte la variable PHP dans une variable JS globale -->
    <script>
        window.objToRender = "<?php echo $post['nom'].'_'.$post['userid']; ?>";
    </script>

    <!-- Script principal qui va utiliser objToRender -->
    <script type="module" src="main.js"></script>
</body>
</html>