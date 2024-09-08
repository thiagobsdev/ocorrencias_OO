<?php

require 'config.php';
require 'models/Auth.php';
require 'models/Envolvido.php';

require_once 'dao/EnvolvidoDAOMySql.php';

$auth = new Auth($pdo, $base);
$excluir = new EnvolvidoDAOMySql($pdo);


$array = ['error' => ''];

$id = intval(filter_input(INPUT_POST, 'id'));

if ($id) {
    $excluir->excluirEnvolvidoById($id);
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao excluir o ativo']);
}
