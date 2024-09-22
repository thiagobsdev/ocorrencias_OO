<div class="container" style="margin-top: 30px;">
    <!-- Comentários -->
    <h6>Comentários:</h6>
    <div class="mb-3">
        <textarea id="comentario" data-id="<?= $ocorrencia->id; ?>" class="form-control comentario_area" rows="3" placeholder="Adicione um comentário"></textarea>
    </div>
    <button class="btn btn-primary btn-adicionar-comentario " id="btn-adicionar-comentario" data-username="<?= $userInfo->nome; ?>" data-id="<?= $ocorrencia->id; ?>" onclick=" cadastrarComentario(this)">Adicionar Comentário</button>

    <!-- Lista de Comentários -->
    <ul class="list-group mt-3" id="lista-comentarios-<?= $ocorrencia->id; ?>">
        <?php if (!empty($ocorrencia->listaComentarios)) : ?>
            <?php foreach ($ocorrencia->listaComentarios as $comentario) : ?>
                <li class="list-group-item" style="margin-bottom: 20px; border: 1px solid gray" id="comentario-<?= $comentario['id']; ?>">
                    <strong style="padding-bottom: 10px;"><?= $comentario['id_usuario']->nome; ?>:</strong>
                    <p style="margin-top: 10px;"><?= nl2br($comentario['texto']); ?></p>
                    <?php $data = DateTime::createFromFormat('Y-m-d H:i:s', $comentario['data_comentario']); ?>
                    <?php $dataFormatada = $data->format('d/m/Y H:i'); ?>
                    <small class="text-muted">Comentado em: <?= $dataFormatada; ?> </small>
                    <!-- Botão de Excluir -->
                    <?php if ($userInfo->nivel === 'Administrador') : ?>
                        <button class="btn btn-danger btn-sm float-end" onclick="excluirComentario(<?= $comentario['id']; ?>)">Excluir</button>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        <?php else : ?>
            <li class="list-group-item">Nenhum comentário foi adicionado ainda.</li>
        <?php endif; ?>
    </ul>
</div>
<script>
    async function excluirComentario(comentarioId) {
        if (confirm('Tem certeza de que deseja excluir este comentário?')) {
            try {
                const formData = new FormData();
                formData.append('comentario_id', comentarioId);

                let req = await fetch(BASE + 'excluir_comentario_action.php', {
                    method: 'POST',
                    body: formData
                });

                let json = await req.json();
                console.log(json.status)

                if (json.status === 'success') {

                    const comentarioElement = document.getElementById(`comentario-${comentarioId}`);
                    comentarioElement.remove();
                    alert('Comentário excluído com sucesso.');
                } else {
                    alert('Erro ao excluir o comentário: ' + (json.message || 'Resposta inválida do servidor'));
                }
            } catch (error) {
                console.error('Erro ao excluir o comentário:', error);
                alert('Ocorreu um erro ao excluir o comentário blabla. Por favor, tente novamente.');
            }
        }
    }
</script>
<script>
    function formatarDataHora(data) {
        const options = {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        };
        return data.toLocaleString('pt-BR', options);
    }
    async function cadastrarComentario(button) {

        let ocorrenciaID = button.getAttribute('data-id');
        let comentarioArea;

        if (ocorrenciaID) {
            novoComentarioArea = document.querySelector(`textarea[data-id='${ocorrenciaID}']`);
            listaComentarios = document.getElementById(`lista-comentarios-${ocorrenciaID}`);
            const usuarioNome = button.getAttribute('data-username');
            novoComentario = novoComentarioArea.value.trim();
            const agora = new Date();
            const dataHoraAtual = formatarDataHora(agora);
            let novoComentarioFormatado = novoComentario.replace(/\n/g, '<br>');
            if (novoComentario !== '') {

                const formData = new FormData();
                formData.append('novoComentario', novoComentario);
                formData.append('ocorrencia_id', ocorrenciaID);
                try {
                    let req = await fetch(BASE + 'adicionar_comentario_action.php', {
                        method: 'POST',
                        body: formData
                    })

                    let json = await req.json()
                        .then(json => {
                            if (json && json.status === 'success') {
                                const novoComentarioId = json.id;
                                const novoItem = document.createElement('li');
                                novoItem.classList.add('list-group-item');
                                novoItem.style.marginBottom = '20px';
                                novoItem.style.border = '1px solid gray';
                                novoItem.id = `comentario-${novoComentarioId}`;

                                novoItem.innerHTML = `<strong>${usuarioNome}:</strong> <p>${novoComentarioFormatado}</p> <small class="text-muted">Comentado em: ${dataHoraAtual}</small>`;

                                novoItem.style.marginTop = '10px';

                                let botaoExcluir = document.createElement('button');
                                botaoExcluir.classList.add('btn', 'btn-danger', 'btn-sm', 'float-end');
                                botaoExcluir.textContent = 'Excluir';
                                botaoExcluir.onclick = function() {
                                    excluirComentario(novoComentarioId, this); // Passando o ID corretamente
                                };

                                novoItem.appendChild(botaoExcluir);

                                novoItem.setAttribute('data-id', novoComentarioId);

                                if (listaComentarios.firstChild) {
                                    listaComentarios.insertBefore(novoItem, listaComentarios.firstChild);
                                } else {

                                    listaComentarios.appendChild(novoItem);
                                }

                                novoComentarioArea.value = "";

                            } else {
                                alert('Erro ao adicionar o comentario: ' + (json.message || 'Resposta inválida do servidor'));
                            }
                        })

                } catch (error) {
                    console.error('Erro ao adicionar o comentario:', error);
                    alert('Ocorreu um erro ao adicionar o comentario. Por favor, tente novamente.');

                }
            } else {
                alert('O comentário não pode estar vazio.');
            }

        }
    }
</script>