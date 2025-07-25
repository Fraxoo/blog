<?php
session_start();
require_once('crud.php');

addpost();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style3.css">
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
        <?php if (isset($_SESSION['id'])): ?>

            <div class="titre">
                <h2>Upload un nouveau model</h2>
            </div>

            <div class="upload">

                <form action="upload.php" method="post" enctype="multipart/form-data">
                    <input type="text" class="nom" name="nom" placeholder="Nom :" required>
                    <input type="text" name="description" class="description" placeholder="Description" required>
                    <input type="file" class="file" name="files[]" webkitdirectory directory multiple required>
                    <button type="submit">Upload</button>
                </form>

            </div>

        <?php else : ?>
            <p>Veuillez vous connecter pour Upload un fichier <a href="login.php">Se Connecter</a></p>
        <?php endif ?>

    </main>


</body>

</html>