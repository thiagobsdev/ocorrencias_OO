<?= $render('header', ['usuariologado' => $usuariologado]) ?>
<main>
    <div class="container mt-5">
        <h2>Modificar Senha</h2>


        <!-- Formulário de Modificação de Senha -->
        <form id="passwordForm" method="POST" action="<?= $base ?>/alterar_senha_usuario_logado">
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
    <?php if (isset($confirmUsuario) && $confirmUsuario === true): ?>
        <div id="flashMessageSenha"
            style="text-align: center; color: green; font-size: 34px; font-weight: bold; margin-bottom: 30px; margin-top: 30px"
            class="flash"><?php echo "Senha alterada com sucesso"; ?></div>
    <?php endif; ?>
    <?php if (empty($confirmUsuario) || $confirmUsuario === false): ?>
        <div id="flashMessageSenha"
            style="text-align: center; color: red; font-size: 34px; font-weight: bold; margin-bottom: 30px; margin-top: 30px"
            class="flash"><?php echo "Erro ao alterar a senha. Verifique os campos digitados!"; ?></div>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
</body>

</html>