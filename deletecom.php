<?php

session_start();

require_once('crud.php');

deletecom();

header('Location: sujet.php?id=' . $_GET['sujet_id']);
exit();

?>
