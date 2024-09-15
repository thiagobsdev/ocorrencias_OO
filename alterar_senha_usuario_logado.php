<?php
require 'config.php';
require 'models/Auth.php';

require_once 'dao/UserDAOMySql.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();

require 'partials/header.php';
?>

<main>
    <div class="container mt-5">
        <h2>Modificar Senha</h2>


        <!-- Formulário de Modificação de Senha -->
        <form id="passwordForm" method="POST" action="<?= $base ?>alterar_senha_usuario_logado_action.php">
            <div class="mb-3">
                <label for="currentPassword" class="form-label">Senha Atual</label>
                <input type="password" class="form-control" id="currentPassword" placeholder="Digite a senha atual" required name="senhaAtual">
            </div>
            <div class="mb-3">
                <label for="newPassword" class="form-label">Nova Senha</label>
                <input type="password" class="form-control" id="newPassword" placeholder="Digite a nova senha" required name="novaSenha">
            </div>
            <div class="mb-3">
                <label for="confirmPassword" class="form-label">Confirme a Nova Senha</label>
                <input type="password" class="form-control" id="confirmPassword" placeholder="Confirme a nova senha" required name="confirmNovaSenha">
            </div>
            <div id="errorMessage" style="color: red; display: none; margin-top: 30px; margin-bottom:30px; font-weight: bold"></div>
            <button type="submit" class="btn btn-primary">Modificar Senha</button>
        </form>
    </div>
    <?php if (isset($_SESSION['flash'])  && $_SESSION['flash'] === "Senha alterada com sucesso!"): ?>
        <!-- Modal -->
        <div class="container d-flex justify-content-center align-items-center">
            <div id="successEditModal" class="modal-overlay" style="display:block;">
                <div class="modal-content">
                    <h5>Sucesso</h5>
                    <p>Senha alterada com sucesso!</p>
                    <button onclick="closeModal()">Fechar</button>
                </div>
            </div>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['flash'])  && $_SESSION['flash'] === "Ocorreu um erro ao tentar alterar a senha. Verifique os campos digitados!"): ?>
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
</main>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const flashMessageSenha = document.getElementById('flashMessageSenha');
        if (flashMessageSenha) {
            setTimeout(function() {
                flashMessageSenha.style.display = 'none';
            }, 2000);
        }
    });
</script>
</script>
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/partials/js/alterar_senha_usuario_logado/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('confirmPassword').addEventListener('blur', function() {
        const password = document.getElementById('newPassword').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        const errorMessage = document.getElementById('errorMessage');

        // Verifica se as senhas são iguais
        if (password !== confirmPassword) {
            errorMessage.textContent = 'As novas senhas não são iguais. Por favor, tente novamente.';
            errorMessage.style.display = 'block'; // Exibe a mensagem de erro
        } else {
            errorMessage.style.display = 'none'; // Oculta a mensagem de erro se as senhas forem iguais
        }
    });
</script>
 <script>
        // Função para fechar o modal
        function closeModal() {
            document.getElementById('successEditModal').style.display = 'none';
        }
</script>
</body>

</html>