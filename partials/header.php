<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ocorrências Segurança Patrimonial</title>
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= $base; ?>bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $base; ?>styles.css">
    <link rel="stylesheet" href="<?= $base; ?>ocorrencia-css.css">
    <link rel="stylesheet" href="/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap-5.3.3-dist/css/bootstrap-utilities.min.css">
    <link rel="shortcut icon" href="<?= $base; ?>assets/fotos/logoDP-World.ico" type="image/x-icon">
    <script src="/partials/js/header/popoer.js"></script>
    <script src="/partials/js/header/jspdf2.umd.min.js"></script>
    <script src="/partials/js/header/html2canvas.min.js"></script>
    <script src=" es6-promise.auto.min.js "> </script>

    <script src="/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        const BASE = "<?= $base; ?>"
    </script>
    
</head>


<body>

    <header class="bg-dark text-white cabecalho">
        <div class="container d-flex justify-content-center align-items-center">
            <div class="cabecalho-conteiner container-fluid">
                <nav class="navbar navbar-expand navbar-dark bg-dark ">
                    <a class="navbar-brand" href="<?= $base; ?>">
                        <img src="<?= $base; ?>assets/fotos/logo.gif" width="70" height="50" alt="">
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav">
                            <li class="nav-item active">
                                <a class="nav-link" href="<?= $base; ?>" style="text-align:center">Ocorrências Registradas <span class="sr-only"></span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= $base; ?>nova_ocorrencia.php" style="text-align:center">Novo Registro de Ocorrência</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a style="text-align:center" class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Pesquisas
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="<?= $base; ?>pesquisa_id.php">Pesquisa por ID</a>
                                    <a class="dropdown-item" href="<?= $base; ?>pesquisa_envolvido.php">Pesquisa por envolvido</a>
                                    <a class="dropdown-item" href="<?= $base; ?>pesquisa_tipo_natureza.php">Pesquisa por tipo e natureza</a>
                                </div>
                            </li>
                            <?php if ($userInfo->nivel === "Administrador"): ?>
                                <li class="nav-item dropdown">
                                    <a style="text-align:center" class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Administrador
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                        <a style="text-align:center" class="dropdown-item" href="<?= $base; ?>cadastro.php">Gerenciar usuários</a>
                                    </div>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="d-flex w-100 justify-content-end">
                <span>
                    Olá, <?= $userInfo->nome; ?>
                </span>
                <a style="margin-left:20px; margin-right:20px;" class="nav-link alterarSenha" href="<?= $base; ?>alterar_senha_usuario_logado.php">Alterar senha</a>
                <a class="nav-link" href="<?= $base; ?>logout.php">Sair</a>
            </div>
        </div>
    </header>