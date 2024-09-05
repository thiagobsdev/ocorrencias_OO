<?php

require 'config.php';
require 'models/Auth.php';

$auth = new Auth($pdo, $base);

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
        <?php  require 'partials/card_filtro_datas.php'; ?>

        <div class="row">
            <div class="col">
                <?php foreach ($ocorrencias['ocorrencias'] as $ocorrencia): ?>

                    <!-- Card Ocorrências -->
                    <?= $render('card_ocorrencia', [
                        'dados' => $ocorrencia,
                        'usuarioLogado' => $usuariologado
                    ]) ?>


                <?php endforeach; ?>
            </div>

        </div>

    
        <!-- Paginação -->
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <!-- Link para a página anterior -->
                <li class="page-item <?php if ($ocorrencias['paginaAtual']  <= 1) {
                                            echo 'disabled';
                                        } ?>">
                    <a class="page-link" href="<?= $base; ?>/?page=<?php $ocorrencias['paginaAtual'] - 1; ?>">Anterior</a>
                </li>

                <!-- Links para as páginas dentro do intervalo definido -->
                <?php for ($i = 0; $i < $ocorrencias['totalDePaginas']; $i++): ?>
                    <li class="page-item <?php if ($i == $ocorrencias['paginaAtual']) {
                                                echo 'active';
                                            } ?>">
                        <a class="page-link" href="<?= $base; ?>/?page=<?= $i; ?>"><?php echo $i + 1; ?></a>
                    </li>
                <?php endfor; ?>

                <!-- Link para a próxima página -->
                <li class="page-item <?php if ($ocorrencias['paginaAtual'] >= $ocorrencias['totalDePaginas']) {
                                            echo 'disabled';
                                        } ?>">
                    <a class="page-link" href="<?= $base; ?>/?page=<?php echo $ocorrencias['paginaAtual'] + 1; ?>">Próximo</a>
                </li>
            </ul>
        </nav>
        <!-- Modal de Visualização PDF -->
        <div class="modal fade" id="printModal" tabindex="-1" aria-labelledby="printModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="printModalLabel">Visualização da Ocorrência em PDF</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <iframe id="pdfViewer" style="width: 100%; height: 600px;" frameborder="0"></iframe>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-primary" id="downloadPdf">Baixar PDF</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require 'partials/footer.php' ?>