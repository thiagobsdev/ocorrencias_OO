<?= $render('header', ['usuariologado' => $usuariologado]) ?>

<body>
    <div class="container mt-5">
        <h2>Gerenciamento de Usuários</h2>

        <!-- Formulário de Usuário -->
        <form id="userForm" method="POST" action="<?= $base; ?>/cadastro">
            <div class="mb-3">
                <label for="userName" class="form-label">Nome</label>
                <input type="text" class="form-control" id="userName" placeholder="Digite o nome" name="nome">
            </div>
            <div class="mb-3">
                <label for="userEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="userEmail" placeholder="Digite o email" name="email">
            </div>
            <div class="mb-3">
                <label for="userPassword" class="form-label">Senha</label>
                <input type="password" class="form-control" id="userPassword" placeholder="Digite a senha" name="senha">
            </div>
            <div class="mb-3">
                <label for="userAccessLevel" class="form-label">Nível de Acesso</label>
                <select class="form-select" id="userAccessLevel" name="nivel">
                    <option selected>Selecione o nível de acesso</option>
                    <option value="Administrador">Administrador</option>
                    <option value="Usuário">Usuário</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option selected>Selecione status do usuário</option>
                    <option value="Ativo">Ativo</option>
                    <option value="Inativo">Inativo</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>

        <!-- Tabela de Usuários -->
        <div class="mt-5">
            <h4>Lista de Usuários</h4>
            <table class="table table-bordered" style="text-align:center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Nível de Acesso</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody id="userTableBody">
                    <?php if (count($usuarios) > 0) : ?>
                        <?php foreach ($usuarios as $usuario) : ?>
                            <tr style="text-align:center;">
                                <td><?= $usuario['id'] ?></td>
                                <td><?= $usuario['nome'] ?></td>
                                <td><?= $usuario['email'] ?>
                                <td><?= $usuario['nivel'] ?></td>
                                <td>
                                    <button id="mudancaStatus" data-id=<?= $usuario['id'] ?> class="btn <?= ($usuario['status'] === 'Ativo') ? 'btn-success' : 'btn-danger'; ?> btn-sm" onclick="toggleUserStatus(this, <?= ($usuario['status'] === 'Ativo') ? true : false; ?>)"><?= $usuario['status'] ?></button>
                                    <button id="resetarSenha" data-id=<?= $usuario['id'] ?> class="btn btn-warning btn-sm" onclick="resetPassword('joao@example.com')">Resetar Senha</button>
                                    <button id="alterarNivel" data-id=<?= $usuario['id'] ?> class="btn btn-info btn-sm " >Alterar nivel de acesso</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

<div class="modal fade" id="confirmAlteraNivel" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteLabel">Confirmação de alteração de nivel de usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="fechaModalAlteraNivel()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Você tem certeza de que deseja alterar nivel do usuário?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="fechaModalAlteraNivel()">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmAlteraNivelAction">Alterar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal de Confirmação de alteração de reset de senha -->
<div class="modal fade" id="confirmAlteraNivelMessage" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteLabel">Mudança de nivel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Nivel do usuário alterado com sucesso!
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function fechaModalAlteraNivel() {
        $('#confirmAlteraStatus').modal('hide'); // fecha o modal de confirmação
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let idUsuario; // Variável para armazenar o ID da ocorrência

        // Captura o clique no botão de exclusão
        document.querySelectorAll('#alterarNivel').forEach(button => {
            button.addEventListener('click', function() {
                idUsuario = this.getAttribute('data-id'); // Captura o ID da ocorrência
                if (idUsuario) {
                    $('#confirmAlteraNivel').modal('show'); // Exibe o modal de confirmação
                }

            });
        });

        // Confirmação de exclusão
        document.getElementById('confirmAlteraNivelAction').addEventListener('click', async function() {
            if (idUsuario) {
                let data = new FormData();
                data.append('id', idUsuario);

                let req = await fetch(BASE + '/alterar_nivel', {
                    method: 'POST',
                    body: data
                })

                let json = await req.json()
                    .then(json => {
                        if (json && json.status === 'success') { // Verifica se 'data' não é undefined ou null
                            // Exibe o modal de confirmação
                            $('#confirmAlteraNivel').modal('hide');
                            $('#confirmAlteraNivelMessage').modal('show');

                            // Aguarda 3 segundos e recarrega a página
                            setTimeout(function() {
                                $('#confirmAlteraNivelMessage').modal('hide');
                                location.reload();
                            }, 2000);
                        } else {
                            alert('Erro ao alterar o nivel do usuário: ' + (json.message || 'Resposta inválida do servidor'));
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao alterar o nivel do usuário:', error);
                        alert('Ocorreu um erro ao tentar ao alterar alterar o nivel do usuário. Por favor, tente novamente.');
                    });


            }
        });
    });
</script>





<!-- Modal de exclusao de ativo -->
<div class="modal fade" id="confirmReseTSenha" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteLabel">Confirmação de alteração de senha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="fechaModalMudancaDeSenha()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Você tem certeza de que deseja a senha do usuário?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="fechaModalMudancaDeSenha()">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmResetSenhaAction">Alterar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal de Confirmação de alteração de reset de senha -->
<div class="modal fade" id="confirmResetSenhaMessage" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteLabel">Mudança de senha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Senha do usuário alterada com sucesso!
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function fechaModalMudancaDeSenha() {
        $('#confirmReseTSenha').modal('hide'); // fecha o modal de confirmação
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let idUsuario; // Variável para armazenar o ID da ocorrência

        // Captura o clique no botão de exclusão
        document.querySelectorAll('#resetarSenha').forEach(button => {
            button.addEventListener('click', function() {
                idUsuario = this.getAttribute('data-id'); // Captura o ID da ocorrência
                if (idUsuario) {
                    $('#confirmReseTSenha').modal('show'); // Exibe o modal de confirmação
                }

            });
        });

        // Confirmação de exclusão
        document.getElementById('confirmResetSenhaAction').addEventListener('click', async function() {
            if (idUsuario) {
                let data = new FormData();
                data.append('id', idUsuario);

                let req = await fetch(BASE + '/resetar/senha', {
                    method: 'POST',
                    body: data
                })

                let json = await req.json()
                    .then(json => {
                        if (json && json.status === 'success') { // Verifica se 'data' não é undefined ou null
                            // Exibe o modal de confirmação
                            $('#confirmReseTSenha').modal('hide');
                            $('#confirmResetSenhaMessage').modal('show');

                            // Aguarda 3 segundos e recarrega a página
                            setTimeout(function() {
                                $('#confirmResetSenhaMessage').modal('hide');
                                location.reload();
                            }, 2000);
                        } else {
                            alert('Erro ao alterar alterar a senha: ' + (json.message || 'Resposta inválida do servidor'));
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao alterar a senha:', error);
                        alert('Ocorreu um erro ao tentar ao alterar a senha:. Por favor, tente novamente.');
                    });


            }
        });
    });
</script>


<!-- Modal de alteracao de status -->
<div class="modal fade" id="confirmMudaStatus" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteLabel">Confirmação de mudança de status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="fechaModalMudancaStatus()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Você tem certeza de que deseja mudar o status do usuário?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="fechaModalMudancaStatus()">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmMudancaStatusAction">Alterar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal de Confirmação de alteracao de status -->
<div class="modal fade" id="confirmMudaStatusMessage" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteLabel">Mudança de status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Usuario alterado com sucesso!
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function fechaModalMudancaStatus() {
        $('#confirmMudaStatus').modal('hide'); // fecha o modal de confirmação
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let idUsuario; // Variável para armazenar o ID da ocorrência

        // Captura o clique no botão de exclusão
        document.querySelectorAll('#mudancaStatus').forEach(button => {
            button.addEventListener('click', function() {
                idUsuario = this.getAttribute('data-id'); // Captura o ID da ocorrência
                if (idUsuario) {
                    $('#confirmMudaStatus').modal('show'); // Exibe o modal de confirmação
                }

            });
        });

        // Confirmação de exclusão
        document.getElementById('confirmMudancaStatusAction').addEventListener('click', async function() {
            if (idUsuario) {
                let data = new FormData();
                data.append('id', idUsuario);

                let req = await fetch(BASE + '/alterar/usuario', {
                    method: 'POST',
                    body: data
                })

                let json = await req.json()
                    .then(json => {
                        if (json && json.status === 'success') { // Verifica se 'data' não é undefined ou null
                            // Exibe o modal de confirmação
                            $('#confirmMudaStatus').modal('hide');
                            $('#confirmMudaStatusMessage').modal('show');

                            // Aguarda 3 segundos e recarrega a página
                            setTimeout(function() {
                                $('#confirmMudaStatusMessage').modal('hide');
                                location.reload();
                            }, 2000);
                        } else {
                            alert('Erro ao alterar status: ' + (json.message || 'Resposta inválida do servidor'));
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao alterar status:', error);
                        alert('Ocorreu um erro ao tentar ao alterar status:. Por favor, tente novamente.');
                    });


            }
        });
    });
</script>

</html>