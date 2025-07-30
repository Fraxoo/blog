<?php
session_start();
if(isset($_SESSION['id'])){
require_once('crud.php');

deleteaccount();
}
header('Location: account.php');


?>