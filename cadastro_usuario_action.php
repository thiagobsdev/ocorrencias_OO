<?php

use src\models\Usuario;

require_once 'dao/UserDAOMySql.php';

require 'config.php';
require 'models/Auth.php';

$nome = filter_input(INPUT_POST, 'nome');
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$senha = filter_input(INPUT_POST, 'senha');
$nivel = filter_input(INPUT_POST, 'nivel');
$status = filter_input(INPUT_POST, 'status');

if ($nome && $email && $senha && $nivel && $status) {

    $novoUsuario = new Usuario();
    $novoUsuario->nome = $nome;
    $novoUsuario->email = $email;
    $novoUsuario->senha = $senha;
    $novoUsuario->nivel = $nivel;
    $novoUsuario->status = $status;
    $userDAO = new UserDAOMySql($pdo);
    $user = $userDAO->cadastrarUsuario($novoUsuario);
    if ($user) {
        $_SESSION['flash'] = "Usuário cadastrado com sucesso!";
        header("Location: " . $base . "cadastro.php");
        exit;
    }

    $_SESSION['flash'] = "Email já cadastrado ou campos incompletos! tente novamente!";
    header("Location: " . $base . "cadastro.php");
    exit;
}
