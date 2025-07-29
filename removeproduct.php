<?php
session_start();
require_once('crud.php');


deletedirectory();
deleteById();

header('Location: account.php');


?>