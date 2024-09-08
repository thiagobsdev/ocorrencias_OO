<?php

require 'config.php';
require 'models/Auth.php';
require 'models/Ativo.php';

require_once 'dao/AtivoDAOMySql.php';

$auth = new Auth($pdo, $base);
$excluir = new AtivoDAOMySql($pdo);


$array = ['error' => ''];

$id = intval(filter_input(INPUT_POST, 'id'));

if ($id) {
    $excluir->excluirAtivoById($id);
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao excluir o ativo']);
}
