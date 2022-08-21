<?php
declare(strict_types=1);
require '../includes/handler.inc.php';
session_start();
$session = new Session();
$session->dashboard();

?>

<a href="./logout.php">Logout</a>