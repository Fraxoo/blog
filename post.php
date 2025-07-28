<?php
session_start();
require_once('crud.php');

$bdd = connect();
$id = $_GET["id"];

// On récupère tous les posts (mais pour l'exemple on va prendre le premier)
$cherche = $bdd->prepare('SELECT * FROM post WHERE id = :id');
$cherche->execute([
    'id' => $id
]);
$post = $cherche->fetch();

$get = $bdd->prepare('SELECT * FROM user INNER JOIN post ON user.id = post.userid WHERE userid = :userid');
$get->execute([
    'userid'=>$post['userid']
]);
$posts = $get->fetch();








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
        <h1><?= $post['nom']?></h1>
        <p>Publier par : <?= $posts['pseudo']?></p>
        <div class="container" id="container3D"></div>
        <p><?= $post['description']?></p>
    </main>








    <!-- On injecte la variable PHP dans une variable JS globale -->
    <script>
        window.objToRender = "<?php echo $post['nom'].'_'.$post['userid']; ?>";
    </script>

    <!-- Script principal qui va utiliser objToRender -->
    <script type="module" src="main.js"></script>
</body>
</html>