<div class="card mb-4 mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <strong>ID:</strong><?= " " . $ocorrencia->id . " "; ?>| <strong>Data:</strong> <?= " " . DateTime::createFromFormat('Y-m-d', $ocorrencia->data_ocorrencia)->format('d/m/Y') . " "; ?> | <strong>Hora:</strong> <?= " " . $ocorrencia->hora_ocorrencia . " "; ?>
            <strong>Registrado por:</strong> <?= " " . $ocorrencia->usuario->nome . " "; ?>
        </div>
        <div>
            <?php if ($userInfo->nivel === "Administrador") :  ?>

                <button data-id="<?= $ocorrencia->id; ?>" href="<?= $base; ?>/excluir/<?= $ocorrencia->id; ?>" class="btn-excluir btn btn-danger">Excluir</button>
                <button style="margin-left: 10px; margin-right: 10px" class="btn btn-warning" onclick="window.location.href='<?= $base; ?>editar.php?ocorrencia_id=<?= $ocorrencia->id; ?>'">Editar</button>

            <?php endif; ?>
            <button class="btn btn-secondary print-btn" onclick="window.location.href='<?= $base; ?>imprimir.php?ocorrencia_id=<?= $ocorrencia->id; ?>'">Imprimir PDF</button>
        </div>
    </div>
    <div class="card-body ocorrencia-content" id="ocorrencia-001">
        <h5 class="card-title" style="text-align:center"><?= " " . $ocorrencia->titulo . " "; ?></h5>
        <p class="card-text">
            <strong>Área:</strong> <?= " " . $ocorrencia->area . " "; ?><br>
            <strong>Local:</strong> <?= " " . $ocorrencia->local . " "; ?><br>
            <strong>Tipo:</strong> <?= " " . $ocorrencia->tipo_natureza . " "; ?><br>
            <strong>Natureza:</strong> <?= " " . $ocorrencia->natureza . " "; ?>
        </p>

        <!-- Informações do Ativo -->

        <h6>Ativos:</h6>

        <?php if (!empty($ocorrencia->ativosLista)) : ?>
            <table class="table table-dark table-striped ">
                <thead>
                    <tr>
                        <th>Tipo de ativo</th>
                        <th>Identificação do ativo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($ocorrencia->ativosLista as $ativo): ?>
                        <tr>
                            <td><?= $ativo['tipo_ativo']; ?></td>
                            <td><?= $ativo['id_ativo']; ?></td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        <?php else : ?>
            <p>A lista de ativos está vazia.</p>
        <?php endif; ?>

        <!-- Se houver envolvidos -->
        <h6>Envolvidos:</h6>

        <?php if (!empty($ocorrencia->envolvidosLista)) : ?>
            <table class="table table-primary table-striped ">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Tipo de Documento</th>
                        <th>Número do Documento</th>
                        <th>Envolvimento</th>
                        <th>Vínculo</th>
                        <th>Tipo de Veículo</th>
                        <th>Placa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ocorrencia->envolvidosLista as $envolvido): ?>
                        <tr>
                            <td><?= $envolvido['nome']; ?></td>
                            <td><?= $envolvido['tipo_de_documento']; ?></td>
                            <td><?= $envolvido['numero_documento']; ?></td>
                            <td><?= $envolvido['envolvimento']; ?></td>
                            <td><?= $envolvido['vinculo']; ?></td>
                            <td><?= $envolvido['tipo_veiculo']; ?></td>
                            <td><?= $envolvido['placa']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>A lista de envolvidos está vazia.</p>
        <?php endif; ?>

        <!-- Descrição da Ocorrência -->
        <h6>Descrição da ocorrência:</h6>
        <p class="card-text"><?= nl2br($ocorrencia->descricao) . " "; ?>.</p>

        <!-- Ações Tomadas -->
        <h6 class="">Ações Tomadas:</h6>
        <p class="card-text"><?= nl2br($ocorrencia->acoes) . " "; ?>.</p>

        <!-- Fotos -->
        <h6>Fotos:</h6>
        <?php if (!empty($ocorrencia->fotosOcorrencias)) : ?>
            <div id="<?= $ocorrencia->id; ?>" class="carousel slide carousel-fade" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php foreach ($ocorrencia->fotosOcorrencias as $foto): ?>
                        <div class="carousel-item active d-flex justify-content-center" style="background-color: rgb(202,198,202);">
                            <img src="<?= $base; ?>/<?= $foto['url']; ?>" class="d-block " alt="<?= $foto['nome']; ?>" style="max-height: 500px">
                        </div>
                    <?php endforeach;; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#<?= $ocorrencia->id; ?>" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#<?= $ocorrencia->id; ?>" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        <?php else : ?>
            <p>A lista de Fotos está vazia.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Modal de exclusao -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteLabel">Confirmação de Exclusão</h5>
                <button type="button" class="close" aria-label="Close" onclick="fechaModalConfirmacaoExclusao()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Você tem certeza de que deseja excluir esta ocorrência?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="fechaModalConfirmacaoExclusao()">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Excluir</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmação -->
<div class="modal fade" id="confirmDeleteModalmessage" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteLabel">Confirmação de Exclusão</h5>
                <button type="button" class="close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Ocorrência excluída com sucesso.
            </div>
        </div>
    </div>
</div>

<script>
    // Função para fechar o modal de confirmação
    function fechaModalConfirmacaoExclusao() {
        document.getElementById('confirmDeleteModal').classList.remove('show');
        document.getElementById('confirmDeleteModal').style.display = 'none';
    }

    document.addEventListener('DOMContentLoaded', function() {
        let occurrenceId; // Variável para armazenar o ID da ocorrência

        // Captura o clique no botão de exclusão
        document.querySelectorAll('.btn-excluir').forEach(button => {
            button.addEventListener('click', function() {
                occurrenceId = this.getAttribute('data-id'); // Captura o ID da ocorrência
                let modal = document.getElementById('confirmDeleteModal');
                modal.classList.add('show'); // Exibe o modal
                modal.style.display = 'block';
            });
        });

        // Confirmação de exclusão
        document.getElementById('confirmDeleteButton').addEventListener('click', async function() {
            if (occurrenceId) {
                let data = new FormData();
                data.append('id', occurrenceId);

                let req = await fetch(BASE + '/excluir.php', {
                    method: 'POST',
                    body: data
                });

                let json = await req.json();
                if (json && json.status === 'success') {
                    let deleteModal = document.getElementById('confirmDeleteModal');
                    let messageModal = document.getElementById('confirmDeleteModalmessage');

                    deleteModal.classList.remove('show');
                    deleteModal.style.display = 'none';

                    messageModal.classList.add('show');
                    messageModal.style.display = 'block';

                    // Aguarda 3 segundos e recarrega a página
                    setTimeout(function() {
                        messageModal.classList.remove('show');
                        messageModal.style.display = 'none';
                        location.reload();
                    }, 2000);
                } else {
                    alert('Erro ao excluir a ocorrência: ' + (json.message || 'Resposta inválida do servidor'));
                }
            }
        });
    });
</script>

<!-- Popper.js (necessário para os tooltips e popovers do Bootstrap) -->
<script src="/partials/js/card_ocorrencia/popper.min.js"></script>

<!-- Bootstrap JS -->
<script src="/partials/js/card_ocorrencia/bootstrap.min.js"></script>