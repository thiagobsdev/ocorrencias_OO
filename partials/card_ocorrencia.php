<div class="card mb-4 mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <strong>ID:</strong><?= " " . $dados->id . " "; ?>| <strong>Data:</strong> <?= " " . DateTime::createFromFormat('Y-m-d', $dados->data_ocorrencia)->format('d/m/Y') . " "; ?> | <strong>Hora:</strong> <?= " " . $dados->hora_ocorrencia . " "; ?>
            <strong>Registrado por:</strong> <?= " " . $dados->usuario->nome . " "; ?>
        </div>
        <div>
            <?php if ($usuarioLogado['nivel'] === "Administrador") :  ?>

                <button data-id="<?= $dados->id; ?>" href="<?= $base; ?>/excluir/<?= $dados->id; ?>" class="btn-excluir btn btn-danger">Excluir</button>
                <button style="margin-left: 10px; margin-right: 10px" class="btn btn-warning" onclick="window.location.href='<?= $base; ?>/editar/<?= $dados->id; ?>'">Editar</button>

            <?php endif; ?>
            <button class="btn btn-secondary print-btn" onclick="window.location.href='<?= $base; ?>/imprimir/<?= $dados->id; ?>'">Imprimir PDF</button>
        </div>
    </div>
    <div class="card-body ocorrencia-content" id="ocorrencia-001">
        <h5 class="card-title" style="text-align:center"><?= " " . $dados->titulo . " "; ?></h5>
        <p class="card-text">
            <strong>Área:</strong> <?= " " . $dados->area . " "; ?><br>
            <strong>Local:</strong> <?= " " . $dados->local . " "; ?><br>
            <strong>Tipo:</strong> <?= " " . $dados->tipo_natureza . " "; ?><br>
            <strong>Natureza:</strong> <?= " " . $dados->natureza . " "; ?>
        </p>

        <!-- Informações do Ativo -->

        <h6>Ativos:</h6>

        <?php if (!empty($dados->ativosLista)) : ?>
            <table class="table table-dark table-striped ">
                <thead>
                    <tr>
                        <th>Tipo de ativo</th>
                        <th>Identificação do ativo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($dados->ativosLista as $ativo): ?>
                        <tr>
                            <td><?= $ativo->tipo_ativo; ?></td>
                            <td><?= $ativo->id_ativo; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>A lista de ativos está vazia.</p>
        <?php endif; ?>

        <!-- Se houver envolvidos -->
        <h6>Envolvidos:</h6>

        <?php if (!empty($dados->envolvidosLista)) : ?>
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
                    <?php foreach ($dados->envolvidosLista as $envolvido): ?>
                        <tr>
                            <td><?= $envolvido->nome; ?></td>
                            <td><?= $envolvido->tipo_de_documento; ?></td>
                            <td><?= $envolvido->numero_documento; ?></td>
                            <td><?= $envolvido->envolvimento; ?></td>
                            <td><?= $envolvido->vinculo; ?></td>
                            <td><?= $envolvido->tipo_veiculo; ?></td>
                            <td><?= $envolvido->placa; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>A lista de envolvidos está vazia.</p>
        <?php endif; ?>

        <!-- Descrição da Ocorrência -->
        <h6>Descrição da ocorrência:</h6>
        <p class="card-text"><?= nl2br($dados->descricao) . " "; ?>.</p>

        <!-- Ações Tomadas -->
        <h6 class="">Ações Tomadas:</h6>
        <p class="card-text"><?= nl2br($dados->acoes) . " "; ?>.</p>

        <!-- Fotos -->
        <h6>Fotos:</h6>
        <?php if (!empty($dados->fotosOcorrencias)) : ?>
            <div id="<?= $dados->id; ?>" class="carousel slide carousel-fade" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php foreach ($dados->fotosOcorrencias as $foto): ?>
                        <div class="carousel-item active d-flex justify-content-center" style="background-color: rgb(202,198,202);">
                            <img src="<?= $base; ?>/<?= $foto->url; ?>" class="d-block " alt="<?= $foto->nome; ?>" style="max-height: 500px" >
                        </div>
                    <?php endforeach;; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#<?= $dados->id; ?>" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#<?= $dados->id; ?>" data-bs-slide="next">
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="fechaModalConfirmacaoExclusao()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Você tem certeza de que deseja excluir esta ocorrência?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="fechaModalConfirmacaoExclusao()">Cancelar</button>
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Ocorrência excluída com sucesso.
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function fechaModalConfirmacaoExclusao() {
        $('#confirmDeleteModal').modal('hide'); // fecha o modal de confirmação
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let occurrenceId; // Variável para armazenar o ID da ocorrência

        // Captura o clique no botão de exclusão
        document.querySelectorAll('.btn-excluir').forEach(button => {
            button.addEventListener('click', function() {
                occurrenceId = this.getAttribute('data-id'); // Captura o ID da ocorrência
                $('#confirmDeleteModal').modal('show'); // Exibe o modal de confirmação
            
            });
        });

        // Confirmação de exclusão
        document.getElementById('confirmDeleteButton').addEventListener('click', async function() {
            if (occurrenceId) {
                let data = new FormData();
                data.append('id', occurrenceId);

                let req = await fetch(BASE + '/excluir', {
                    method: 'POST',
                    body: data
                })

                let json = await req.json()
                    .then(json => {
                        if (json && json.status === 'success') { // Verifica se 'data' não é undefined ou null
                            // Exibe o modal de confirmação
                            $('#confirmDeleteModal').modal('hide');
                            $('#confirmDeleteModalmessage').modal('show');

                            // Aguarda 3 segundos e recarrega a página
                            setTimeout(function() {
                                $('#confirmDeleteModalmessage').modal('hide');
                                location.reload();
                            }, 2000);
                        } else {
                            alert('Erro ao excluir a ocorrência: ' + (json.message || 'Resposta inválida do servidor'));
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao excluir a ocorrência:', error);
                        alert('Ocorreu um erro ao tentar excluir a ocorrência. Por favor, tente novamente.');
                    });


            }
        });
    });
</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Popper.js (necessário para os tooltips e popovers do Bootstrap) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>