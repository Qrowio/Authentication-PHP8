<?php
declare(strict_types=1);
session_start();
include "./src/registerForm.php";
require './includes/handler.inc.php';
$session = new Session();
$session->user();
new Register();