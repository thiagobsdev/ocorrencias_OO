<?php

require 'config.php';
require 'models/Auth.php';
require 'models/Ocorrencia.php';

require_once 'dao/OcorrenciaDAOMySql.php';

$auth = new Auth($pdo, $base);
$getOcorrencias = new OcorrenciaDAOMySql($pdo);

$userInfo = $auth->checkToken();
$ocorrenciasArray = $getOcorrencias->listarTodasOcorrencias();


if (!empty($ocorrenciasArray)) {
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
        <?php require 'partials/card_filtro_datas.php'; ?>
        <?php if (isset($_SESSION['flash'])  && $_SESSION['flash'] === "ocorrência editada com sucesso!"): ?>
            <!-- Modal -->
            <div class="container d-flex justify-content-center align-items-center">
                <div id="successEditModal" class="modal-overlay" style="display:block;">
                    <div class="modal-content">
                        <h5>Sucesso</h5>
                        <p>A ocorrência foi editada com sucesso!</p>
                        <button onclick="closeModal()">Fechar</button>
                    </div>
                </div>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['flash'])  && $_SESSION['flash'] === "erro ao editar a ocorrência!"): ?>
            <!-- Modal -->
            <div class="container d-flex justify-content-center align-items-center">
                <div id="successEditModal" class="modal-overlay" style="display:block;">
                    <div class="modal-content">
                        <h5>ERRO!</h5>
                        <p>Erro ao editar a ocorrências!</p>
                        <button onclick="closeModal()">Fechar</button>
                    </div>
                </div>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <div class="row">
            <div class="col">
                <?php if (!empty($ocorrencias)) : ?>
                    <?php foreach ($ocorrencias as $ocorrencia): ?>
                        <!-- Card Ocorrências -->
                        <?php require 'partials/card_ocorrencia.php' ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <?php echo 'Nenhuma ocorrencia registrada!'; ?>
                <?php endif; ?>
            </div>

        </div>
        <?php if (!empty($ocorrenciasArray)) : ?>
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <!-- Link para a página anterior -->
                    <li class="page-item <?php if ($ocorrenciasArray['paginaAtual']  <= 1) {
                                                echo 'disabled';
                                            } ?>">
                        <a class="page-link" href="<?= $base; ?>?p=<?php $ocorrenciasArray['paginaAtual'] - 1; ?>">Anterior</a>
                    </li>

                    <!-- Links para as páginas dentro do intervalo definido -->
                    <?php for ($i = 0; $i < $ocorrenciasArray['totalDePaginas']; $i++): ?>
                        <li class="page-item <?php if ($i == $ocorrenciasArray['paginaAtual'] - 1) {
                                                    echo 'active';
                                                } ?>">
                            <a class="page-link" href="<?= $base; ?>?p=<?= $i + 1; ?>"><?php echo $i + 1; ?></a>
                        </li>
                    <?php endfor; ?>

                    <!-- Link para a próxima página -->
                    <li class="page-item <?php if ($ocorrenciasArray['paginaAtual'] >= $ocorrenciasArray['totalDePaginas']) {
                                                echo 'disabled';
                                            } ?>">
                        <a class="page-link" href="<?= $base; ?>?p=<?php echo $ocorrenciasArray['paginaAtual'] + 1; ?>">Próximo</a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>
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
    <script>
        // Função para fechar o modal
        function closeModal() {
            document.getElementById('successEditModal').style.display = 'none';
        }
    </script>

    <?php require 'partials/footer.php' ?>