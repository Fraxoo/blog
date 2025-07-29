<?php
session_start();
require_once('crud.php');

deleteaccount();

header('Location: account.php');


?>