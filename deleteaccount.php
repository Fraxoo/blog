<?php
session_start();
require_once('crud.php');
if(isset($_SESSION['id'])){

deleteaccount();
}
header('Location: account.php');


?>