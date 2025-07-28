<?php
session_start();
require_once('crud.php');

getById();

unlink('uploads/'.$product['nom'].'_'.$product['userid']);
deleteById();

header('Location: account.php');


?>