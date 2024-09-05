<?php
session_start();
$base = "http://localhost/Sistema%20de%20controle%20de%20ocorrencias%20-%20OO/";

$db_name = "dpwocorrencias";
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';

$pdo = new PDO("mysql:dbname=" . $db_name . ";host=" . $db_host, $db_user, $db_password);
