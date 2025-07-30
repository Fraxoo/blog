<?php 

session_start();

require_once('crud.php');
if(isset($_SESSION['id'])){

deletefavoris();
}
header('Location: account.php');

?>