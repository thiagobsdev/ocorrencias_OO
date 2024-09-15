<?php

use src\models\Ocorrencia;

require 'config.php';
require 'models/Auth.php';
require 'models/Ocorrencia.php';
require_once 'dao/OcorrenciaDAOMySql.php';
require_once 'dao/EnvolvidoDAOMySql.php';
require_once 'dao/AtivoDAOMySql.php';
require_once 'dao/FotoDAOMySql.php';

$auth = new Auth($pdo, $base);

$userInfo = $auth->checkToken();


$id_ocorrencia = intval(filter_input(INPUT_GET, 'ocorrencia_id'));


$equipe =  filter_input(INPUT_POST, 'equipe');
$forma_conhecimento =  filter_input(INPUT_POST, 'forma_conhecimento', FILTER_SANITIZE_SPECIAL_CHARS);
$data_ocorrencia =  filter_input(INPUT_POST, 'data_ocorrencia');
$hora_ocorrencia =  filter_input(INPUT_POST, 'hora_ocorrencia');
$titulo =  filter_input(INPUT_POST, 'titulo');
$area =  filter_input(INPUT_POST, 'area');
$local =  filter_input(INPUT_POST, 'local');
$tipo_natureza =  filter_input(INPUT_POST, 'tipo_natureza');
$natureza =  filter_input(INPUT_POST, 'natureza');
$descricao =  filter_input(INPUT_POST, 'descricao');
$acoes =  filter_input(INPUT_POST, 'acoes');
$id_usuario = $userInfo->id;
$envolvidos = isset($_POST['envolvidos']) ? $_POST['envolvidos'] : null;
$ativosLista = isset($_POST['ativos']) ? $_POST['ativos'] : null;
$arquivosFotos = isset($_FILES['fotos']) ? $_FILES['fotos'] : null;

if (
    $id_ocorrencia &&
    $equipe &&
    $forma_conhecimento &&
    $data_ocorrencia &&
    $hora_ocorrencia &&
    $titulo &&
    $area &&
    $local &&
    $tipo_natureza &&
    $natureza &&
    $descricao
) {
    $ocorrenciaDAO = new OcorrenciaDAOMySql($pdo);
    $ocorrenciaAtualizada = $ocorrenciaDAO->atualizaOcorrenciaById(
        $id_ocorrencia,
        $equipe,
        $forma_conhecimento,
        $data_ocorrencia,
        $hora_ocorrencia,
        $titulo,
        $area,
        $local,
        $tipo_natureza,
        $natureza,
        $descricao,
        $acoes,
        $id_usuario
    );

    if ($ocorrenciaAtualizada && !empty($envolvidos)) {
        $envolvidosDAO = new EnvolvidoDAOMySql($pdo);
        $envolvidosDAO->atualizarEnvolvidos($envolvidos, $id_ocorrencia);
    }

    if ($ocorrenciaAtualizada && !empty($ativosLista)) {
        $ativosDAO = new AtivoDAOMySql($pdo);
        $ativosDAO->atualizarAtivos($ativosLista, $id_ocorrencia);
    }

    if ($ocorrenciaAtualizada && !empty($arquivosFotos)) {
        $fotosDAO = new FotoDAOMySql($pdo);
        $fotosDAO->salvarFotos($arquivosFotos, $data_ocorrencia, $id_ocorrencia, $id_usuario);
    }
    if ($ocorrenciaAtualizada) {
        $_SESSION['flash'] = "ocorrência editada com sucesso!";
        header("Location: " . $base . "index.php");
        exit;
    }
}
$_SESSION['flash'] = "erro ao editar a ocorrência!";
header("Location: " . $base . "index.php");
exit;
