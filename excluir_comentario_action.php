<?php

require 'config.php';
require 'models/Auth.php';
require 'models/Comentario.php';

require_once 'dao/ComentarioDAOMySql.php';

$auth = new Auth($pdo, $base);
$excluirComentario = new ComentarioDAOMySql($pdo);

$userInfo = $auth->checkToken();


$array = ['error' => ''];

$comentario_id = intval(filter_input(INPUT_POST, 'comentario_id'));


if (!empty($comentario_id) ) {

    $excluirComentario->excluirComentario($comentario_id);
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao cadastrar o comentario']);
}
