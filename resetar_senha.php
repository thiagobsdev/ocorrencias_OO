<?php

require 'config.php';
require 'models/Auth.php';


require_once 'dao/UserDAOMySql.php';

$auth = new Auth($pdo, $base);
$resetarSenhaDAO = new UserDAOMySql($pdo);


$array = ['error' => ''];

$id = intval(filter_input(INPUT_POST, 'id'));


if ($id) {
    $resetarSenhaDAO->resetarSenhaDAOByUsuarioID($id);
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao alterar o nível do usuário']);
}