<?php

require 'config.php';
require 'models/Auth.php';
require 'models/Foto.php';

require_once 'dao/FotoDAOMySql.php';

$auth = new Auth($pdo, $base);
$excluir = new FotoDAOMySql($pdo);


$array = ['error' => ''];

$id = intval(filter_input(INPUT_POST, 'id'));

if ($id) {
    $excluir->excluirFotoById($id);
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao excluir a foto']);
}
