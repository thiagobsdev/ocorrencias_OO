<?php

require 'config.php';
require 'models/Auth.php';
require 'models/Ocorrencia.php';

require_once 'dao/OcorrenciaDAOMySql.php';

$auth = new Auth($pdo, $base);
$ocorrenciaDAO = new OcorrenciaDAOMySql($pdo);
$userInfo = $auth->checkToken();

$tipo = filter_input(INPUT_POST, 'tipo_natureza');
$natureza = filter_input(INPUT_POST, 'natureza');

$dataInicio = filter_input(INPUT_POST, 'dataInicio');
$dataFim = filter_input(INPUT_POST, 'dataFim');

($dataInicio === "") ? $dataInicio = '1990-01-01' : $dataInicio;
($dataFim === '') ?  $dataFim = '2100-12-31' : $dataFim;

$ocorrenciasArray = $ocorrenciaDAO->getOcorrenciaByTipoAndNatureza(
    $tipo,
    $natureza,
    $dataInicio,
    $dataFim
);

if ($ocorrenciasArray) {
    $ocorrencias = $ocorrenciasArray['ocorrencias'];
}
require 'partials/header.php';
?>

<div class="d-flex">

    <div class="container my-5">

        <h1 class="text-center mt-xxl-5 mt-xl-5 mt-md-5 mt-lg-5 mt-md-4 mt-5">OCORRÊNCIAS SEGURANÇA PATRIMONIAL</h1>

        <!-- Toggle para o Card de Filtros -->
        <?php require 'partials/card_filtro_tipo_natureza.php'; ?>

    </div>
</div>
<div class="container">
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