<?php
declare(strict_types=1);
session_start();
include "./src/loginForm.php";
require './includes/handler.inc.php';
new Login();
$session = new Session();
$session->user();
