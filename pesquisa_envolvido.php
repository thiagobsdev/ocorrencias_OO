<?php

require 'config.php';
require 'models/Auth.php';
require 'models/Ocorrencia.php';

require_once 'dao/OcorrenciaDAOMySql.php';

$auth = new Auth($pdo, $base);
$ocorrenciaDAO = new OcorrenciaDAOMySql($pdo);
$userInfo = $auth->checkToken();


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
    </div>

    <?php require 'partials/footer.php' ?>