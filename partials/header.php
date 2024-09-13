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
    <link rel="shortcut icon" href="<?= $base; ?>assets/fotos/logoDP-World.ico" type="image/x-icon">
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/partials/js/header/bootstrap.bundle2.min.js"></script>
    <script src="/partials/js/header/popper2.min.js"></script>
    <script src="/partials/js/header/jquery2-3.3.1.slim.min.js"></script>
    <script src="/partials/js/header/popper3.min.js"></script>
    <script src="/partials/js/header/bootstrap2.min.js"></script>

    <script src="/partials/js/header/jspdf2.umd.min.js"></script>
    <script src="/partials/js/header/html2canvas.min.js"></script>
    <script src=" es6-promise.auto.min.js "> </script>
    <script src=" jspdf.min.js "> </script>
    <script src=" html2canvas.min.js "> </script>
    <script src=" html2pdf.bundle.min.js "> </script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/partials/js/header/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">
        const BASE = "<?= $base; ?>"
        const dropdownElementList = document.querySelectorAll('.dropdown-toggle')
        const dropdownList = [...dropdownElementList].map(dropdownToggleEl => new bootstrap.Dropdown(dropdownToggleEl))
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
                            <li class="nav-item">
                                <a class="nav-link" href="<?= $base; ?>pesquisa_id.php" style="text-align:center">Pesquisa por ID</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= $base; ?>pesquisa_envolvido.php" style="text-align:center">Pesquisa por envolvido</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= $base; ?>pesquisa_tipo_natureza.php" style="text-align:center">Pesquisa por tipo e natureza</a>
                            </li>
                            <?php if ($userInfo->nivel === "Administrador"): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= $base; ?>cadastro.php" style="text-align:center">Gerenciar usuários</a>
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