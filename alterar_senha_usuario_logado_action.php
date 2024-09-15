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

if ($senhaAtual && $novaSenha &&  $confirmaSenha && $id_usuario) {
    if ($novaSenha ===  $confirmaSenha) {
        $confirmUsuario = $alteraSenhaUsuarioLogado->alteraSenhaUsuarioLogado($senhaAtual, $novaSenha, $id_usuario);
        if ($confirmUsuario) {
            $_SESSION['flash'] = "Senha alterada com sucesso!";
            header("Location: " . $base . "alterar_senha_usuario_logado.php");
            exit;
        }
    }
}
$_SESSION['flash'] = "Ocorreu um erro ao tentar alterar a senha. Verifique os campos digitados!";
header("Location: " . $base . "alterar_senha_usuario_logado.php");
exit;
