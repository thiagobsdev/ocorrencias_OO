<?php

require 'config.php';
require 'models/Auth.php';
require 'models/Ocorrencia.php';

require_once 'dao/OcorrenciaDAOMySql.php';

$auth = new Auth($pdo, $base);
$ocorrenciaDAO = new OcorrenciaDAOMySql($pdo);
$userInfo = $auth->checkToken();

$nomeEnvolvido = filter_input(INPUT_POST, 'nomeEnvolvido');
$numeroDocumentoEnvolvido = filter_input(INPUT_POST, 'numeroDocumentoEnvolvido');
$envolvimentoEnvolvido = filter_input(INPUT_POST, 'envolvimentoEnvolvido');
$dataInicio = filter_input(INPUT_POST, 'dataInicio');
$dataFim = filter_input(INPUT_POST, 'dataFim');

($dataInicio === "") ? $dataInicio = '1990-01-01' : $dataInicio;
($dataFim === '') ?  $dataFim = '2100-12-31' : $dataFim;


// ($nomeEnvolvido !== "") ? $nomeEnvolvido : $nomeEnvolvido = '*';
// ($numeroDocumentoEnvolvido !== "") ?  $numeroDocumentoEnvolvido : $numeroDocumentoEnvolvido = '*';
// ($envolvimentoEnvolvido !== "") ? $envolvimentoEnvolvido :  $envolvimentoEnvolvido = '*';

$ocorrenciasArray = $ocorrenciaDAO->getOcorrenciaByEnvolvido(
    $nomeEnvolvido,
    $numeroDocumentoEnvolvido,
    $envolvimentoEnvolvido,
    $dataInicio,
    $dataFim
);

if ($ocorrenciasArray) {
    $ocorrencias = $ocorrenciasArray['ocorrencias'];
}

require 'partials/header.php';

?>
<div class="d-flex">

    <div class="container-xxl my-5">


        <h1 class="text-center mt-xxl-5 mt-xl-5 mt-md-5 mt-lg-5 mt-md-4 mt-5">OCORRÊNCIAS SEGURANÇA PATRIMONIAL</h1>
        <?php if (!empty($flash) && $flash == 'Ocorrencia editada com sucesso!'): ?>
            <div id="flashMessageEdit"
                style="text-align: center; color: green; font-size: 34px; font-weight: bold; margin-bottom: 30px; margin-top: 30px"
                class="flash"><?php echo $flash; ?></div>
        <?php endif; ?>
        <!-- Toggle para o Card de Filtros -->
        <?php require 'partials/card_filtro_envolvidos.php'; ?>
        <div class="row">
            <div class="col">
                <?php if (!empty($ocorrencias)): ?>
                    <?php foreach ($ocorrencias as $ocorrencia): ?>
                        <!-- Card Ocorrências -->
                        <?php require 'partials/card_ocorrencia.php' ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <?php echo 'Nenhuma ocorrência encontrada!' ?>
                <?php endif; ?>
            </div>

        </div>
    </div>

    <?php require 'partials/footer.php' ?>