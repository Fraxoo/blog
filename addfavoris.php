<?php 

session_start();
require_once('crud.php');
$postid = $_GET['id'];
$userid = $_SESSION['id'];

$bdd = connect();
$request = $bdd->prepare('INSERT INTO favoris (postid,userid) VALUES (:postid,:userid)');
$request->execute([
    'postid' => $postid,
    'userid' => $userid
]);

header('location:post.php?id='.$postid);

?>