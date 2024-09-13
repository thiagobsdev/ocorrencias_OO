<?php

require 'config.php';
require 'models/Auth.php';
require 'models/Ocorrencia.php';

require_once 'dao/OcorrenciaDAOMySql.php';

$auth = new Auth($pdo, $base);
$excluir = new OcorrenciaDAOMySql($pdo);


$array = ['error' => ''];

$id = intval(filter_input(INPUT_POST, 'id'));


if ($id) {
    $excluir->excluirOcorrencia($id);
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao excluir a ocorrência']);
}

