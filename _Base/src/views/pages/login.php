<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= $base; ?>/css/styles.css">
    <link rel="stylesheet" href="<?= $base; ?>/bootstrap/css/bootstrap.min.css">

    <title>Login Security System</title>
    <style>
        .flash {
            margin-top: 20px;
            background-color: rgb(248, 35, 35);
            text-align: center;
            color: white;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container flex login-container">
        <div class="container sist-container-centralizado">
            <div class="row">
                <div class="col-6 conteiner-logo">
                    <img class="logoTipoDPW" src="<?= $base; ?>/assets/fotos/logo.gif" alt="">
                </div>
                <div class="col-6">

                    <div class="row">
                        <div class="col-sm-12 ">
                            <h1 class="text-center titulo-login">SISTEMA DE CONTROLE DE OCORRÊNCIAS</h1>
                        </div>
                        <div class="col-sm-12">
                            <form method="POST" class="conteiner-formLogin" action="<?= $base; ?>/login">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Endereço de email</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" placeholder="Seu email" name="email">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Senha</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1"
                                        placeholder="Senha" name="senha">
                                    <small id="emailHelp" class="form-text text-muted">Não compartilhe a sua senha com ninguem.</small>
                                    <?php if (!empty($flash)): ?>
                                        <div class="flash"><?php echo $flash; ?></div>
                                        <?php $flash = "";?>
                                    <?php endif; ?>
                                </div>
                                <button type="submit" class="btn btn-primary button-login">Enviar</button>
                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <script src="<?= $base; ?>/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>