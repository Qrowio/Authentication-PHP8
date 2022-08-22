<?php
declare(strict_types=1);
require '../includes/handler.inc.php';
session_start();    
$session = new Session();
$session->dashboard();
$database = new Database();
// echo $_SESSION['user']['email'];    
// print_r($database->select("*", "users", ['email' => $_SESSION['user']['email']]));
// $database->delete("testing", ['id' => 4]);
// $database->delete('testing');
?>

<a href="./logout.php">Logout</a>