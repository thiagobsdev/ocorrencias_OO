<?php
require 'config.php';
require 'models/Auth.php';


$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$senha = filter_input(INPUT_POST, 'senha');

if ($email && $senha) {

    $auth = new Auth($pdo, $base);

    if($auth->validateLogin($email, $senha)) {

        header("Location: ".$base."index.php");
        exit;
    }

}
$_SESSION['flash'] = "email e/ou senha incorretos!";
header("Location: ".$base."login.php");
exit;
  
