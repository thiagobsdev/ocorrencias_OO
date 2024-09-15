<?php
require 'config.php';
require 'models/Auth.php';

require_once 'dao/UserDAOMySql.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();

$usuarioDAO = new UserDAOMySql($pdo);
if ($usuarioDAO) {
    $usuarios = $usuarioDAO->getAllUsuarios();
}

require 'partials/header.php';
?>

<body>

    <div class="container mt-5">
        <?php if (isset($_SESSION['flash'])  && $_SESSION['flash'] === "Usuário cadastrado com sucesso!"): ?>
            <!-- Modal -->
            <div class="container d-flex justify-content-center align-items-center">
                <div id="successEditModal" class="modal-overlay" style="display:block;">
                    <div class="modal-content">
                        <h5>Sucesso</h5>
                        <p>Usuário cadastrado com sucesso!</p>
                        <button onclick="closeModal()">Fechar</button>
                    </div>
                </div>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['flash'])  && $_SESSION['flash'] === "Email já cadastrado ou campos incompletos! tente novamente!"): ?>
            <!-- Modal -->
            <div class="container d-flex justify-content-center align-items-center">
                <div id="successEditModal" class="modal-overlay" style="display:block;">
                    <div class="modal-content">
                        <h5>ERRO!</h5>
                        <p>Erro ao alterar a senha! verifique os campos digitados!</p>
                        <button onclick="closeModal()">Fechar</button>
                    </div>
                </div>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>
        <h2>Gerenciamento de Usuários</h2>

        <!-- Formulário de Usuário -->
        <form id="userForm" method="POST" action="<?= $base; ?>cadastro_usuario_action.php">
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
                                    <button id="alterarNivel" data-id=<?= $usuario['id'] ?> class="btn btn-info btn-sm ">Alterar nivel de acesso</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
<script>
    // Função para fechar o modal
    function closeModal() {
        document.getElementById('successEditModal').style.display = 'none';
    }
</script>
<!-- Modal de alteração de nível -->
<div class="modal fade" id="confirmMudancaStatus" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteLabel">Confirmação de mudança de status do usuário</h5>
                <button type="button" class="close" aria-label="Close" onclick="fechaModal('confirmMudancaStatus')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Você tem certeza de que deseja alterar o status do usuário?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="fechaModal('confirmMudancaStatus')">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmMudancaStatusAction">Alterar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmação -->
<div class="modal fade" id="confirmMudancaStatusMessage" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteLabel">MUDANÇA DE STATUS</h5>
                <button type="button" class="close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                STATUS DO USUÁRIO ALTERADO COM SUCESSO!
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let idUsuario;

        // Captura o clique no botão de alterar nível
        document.querySelectorAll('#mudancaStatus').forEach(button => {
            button.addEventListener('click', function() {
                idUsuario = this.getAttribute('data-id');
                if (idUsuario) {
                    abreModal('confirmMudancaStatus');
                }
            });
        });

        // Confirmação de alteração de nível
        document.getElementById('confirmMudancaStatusAction').addEventListener('click', async function() {
            if (idUsuario) {
                let data = new FormData();
                data.append('id', idUsuario);

                let req = await fetch('<?= $base; ?>alterar_status_usuario.php', {
                    method: 'POST',
                    body: data
                });

                let json = await req.json();
                if (json && json.status === 'success') {
                    fechaModal('confirmMudancaStatus');
                    abreModal('confirmMudancaStatusMessage');

                    setTimeout(function() {
                        fechaModal('confirmMudancaStatusMessage');
                        location.reload();
                    }, 2000);
                } else {
                    alert('Erro ao mudar o status do usuário: ' + (json.message || 'Resposta inválida do servidor'));
                }
            }
        });
    });
</script>

<!-- Modal de alteração de nível -->
<div class="modal fade" id="confirmResetarSenha" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteLabel">Confirmação de alteração de senhas de usuário</h5>
                <button type="button" class="close" aria-label="Close" onclick="fechaModal('confirmResetarSenha')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Você tem certeza de que deseja resetar a senha do usuário?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="fechaModal('confirmResetarSenha')">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmResetarSenhaAction">Alterar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmação -->
<div class="modal fade" id="confirmResetarSenhaMessage" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteLabel">RESET DE SENHA</h5>
                <button type="button" class="close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                SENHA DO USUÁRIO REINICIADA COM SUCESSO
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let idUsuario;

        // Captura o clique no botão de alterar nível
        document.querySelectorAll('#resetarSenha').forEach(button => {
            button.addEventListener('click', function() {
                idUsuario = this.getAttribute('data-id');
                if (idUsuario) {
                    abreModal('confirmResetarSenha');
                }
            });
        });

        // Confirmação de alteração de nível
        document.getElementById('confirmResetarSenhaAction').addEventListener('click', async function() {
            if (idUsuario) {
                let data = new FormData();
                data.append('id', idUsuario);

                let req = await fetch('<?= $base; ?>resetar_senha.php', {
                    method: 'POST',
                    body: data
                });

                let json = await req.json();
                if (json && json.status === 'success') {
                    fechaModal('confirmResetarSenha');
                    abreModal('confirmResetarSenhaMessage');

                    setTimeout(function() {
                        fechaModal('confirmResetarSenhaMessage');
                        location.reload();
                    }, 2000);
                } else {
                    alert('Erro ao resetar a senha do usuário: ' + (json.message || 'Resposta inválida do servidor'));
                }
            }
        });
    });
</script>



<!-- Modal de alteração de nível -->
<div class="modal fade" id="confirmAlteraNivel" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteLabel">Confirmação de alteração de nível de usuário</h5>
                <button type="button" class="close" aria-label="Close" onclick="fechaModal('confirmAlteraNivel')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Você tem certeza de que deseja alterar o nível do usuário?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="fechaModal('confirmAlteraNivel')">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmAlteraNivelAction">Alterar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmação -->
<div class="modal fade" id="confirmAlteraNivelMessage" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteLabel">Mudança de nível</h5>
                <button type="button" class="close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Nível do usuário alterado com sucesso!
            </div>
        </div>
    </div>
</div>

<script>
    // Função para fechar o modal
    function fechaModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.remove('show');
        modal.style.display = 'none';
    }

    // Função para abrir o modal
    function abreModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.add('show');
        modal.style.display = 'block';
    }

    document.addEventListener('DOMContentLoaded', function() {
        let idUsuario;

        // Captura o clique no botão de alterar nível
        document.querySelectorAll('#alterarNivel').forEach(button => {
            button.addEventListener('click', function() {
                idUsuario = this.getAttribute('data-id');
                if (idUsuario) {
                    abreModal('confirmAlteraNivel');
                }
            });
        });

        // Confirmação de alteração de nível
        document.getElementById('confirmAlteraNivelAction').addEventListener('click', async function() {
            if (idUsuario) {
                let data = new FormData();
                data.append('id', idUsuario);

                let req = await fetch('<?= $base; ?>alterar_nivel.php', {
                    method: 'POST',
                    body: data
                });

                let json = await req.json();
                if (json && json.status === 'success') {
                    fechaModal('confirmAlteraNivel');
                    abreModal('confirmAlteraNivelMessage');

                    setTimeout(function() {
                        fechaModal('confirmAlteraNivelMessage');
                        location.reload();
                    }, 2000);
                } else {
                    alert('Erro ao alterar o nível do usuário: ' + (json.message || 'Resposta inválida do servidor'));
                }
            }
        });
    });
</script>



</html>