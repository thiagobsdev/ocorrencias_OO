<?php

require 'config.php';
require 'models/Auth.php';

require_once 'models/Usuario.php';
require_once 'dao/UserDAOMySql.php';

$auth = new Auth($pdo, $base);

$userInfo = $auth->checkToken();
$alteraSenhaUsuarioLogado = new UserDAOMySql($pdo);

$senhaAtual = filter_input(INPUT_POST, 'senhaAtual');
$novaSenha = filter_input(INPUT_POST, 'novaSenha');
$confirmaSenha = filter_input(INPUT_POST, 'confirmNovaSenha');
$id_usuario = $userInfo->id;

// print_r($senhaAtual);
// exit;

if ($senhaAtual && $novaSenha &&  $confirmaSenha && $id_usuario) {
    if ($novaSenha ===  $confirmaSenha) {
        $confirmUsuario = $alteraSenhaUsuarioLogado->alteraSenhaUsuarioLogado($senhaAtual, $novaSenha, $id_usuario);
    } else {
        $_SESSION['flash'] = "Ocorreu um erro ao tentar alterar a senha. Verifique os campos digitados!";
        $this->redirect('/alterar_senha');
    }
}
