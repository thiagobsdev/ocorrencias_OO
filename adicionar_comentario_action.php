<?php

require 'config.php';
require 'models/Auth.php';
require 'models/Comentario.php';

require_once 'dao/ComentarioDAOMySql.php';

$auth = new Auth($pdo, $base);
$adicionarComentarioDAO = new ComentarioDAOMySql($pdo);

$userInfo = $auth->checkToken();


$array = ['error' => ''];

$id_ocorrencia = intval(filter_input(INPUT_POST, 'ocorrencia_id'));
$texto = filter_input(INPUT_POST, 'novoComentario');
$id_usuario = $userInfo->id;

if (!empty($id_ocorrencia) && !empty($texto) && !empty($id_usuario)) {

    $novoComentarioId = $adicionarComentarioDAO->cadastrarComentario($texto, $id_ocorrencia, $id_usuario);
    echo json_encode([
        'status' => 'success',
        "id" => $novoComentarioId
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao cadastrar o comentario']);
}
