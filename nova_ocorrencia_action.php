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
$envolvidos = $_POST['envolvidos'];
$ativos = $_POST['ativos'];
$arquivosFotos = $_FILES['fotos'];

// print_r($ativos);

if (
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
    $novaOcorrencia = new Ocorrencia();
    $novaOcorrencia->equipe = $equipe;
    $novaOcorrencia->forma_conhecimento = $forma_conhecimento;
    $novaOcorrencia->data_ocorrencia = $data_ocorrencia;
    $novaOcorrencia->hora_ocorrencia = $hora_ocorrencia;
    $novaOcorrencia->titulo = $titulo;
    $novaOcorrencia->area = $area;
    $novaOcorrencia->local = $local;
    $novaOcorrencia->tipo_natureza = $tipo_natureza;
    $novaOcorrencia->natureza = $natureza;
    $novaOcorrencia->descricao = $descricao;
    $novaOcorrencia->acoes = $acoes;
    $novaOcorrencia->usuario = $id_usuario;

    $id_ocorrencia =  $ocorrenciaDAO->cadastrarNovaOcorrencia($novaOcorrencia);

    if ($id_ocorrencia > 0 && !empty($envolvidos)) {
        $envolvidosDAO = new EnvolvidoDAOMySql($pdo);
        $envolvidosDAO->cadastrarEnvolvidos($envolvidos, $id_ocorrencia);
    }

    if ($id_ocorrencia > 0 && !empty($ativos)) {
        $ativosDAO = new AtivoDAOMySql($pdo);
        $ativosDAO->cadastrarAtivos($ativos, $id_ocorrencia);
    }

    if ($id_ocorrencia > 0 && !empty($arquivosFotos)) {
        $fotosDAO = new FotoDAOMySql($pdo);
        $fotosDAO->salvarFotos($arquivosFotos, $data_ocorrencia, $id_ocorrencia, $id_usuario);
    }

    header("Location: " . $base . "index.php");
    exit;
}
