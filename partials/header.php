<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ocorrências Segurança Patrimonial</title>
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= $base; ?>/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $base; ?>/styles.css">
    <link rel="stylesheet" href="<?= $base; ?>/ocorrencia-css.css">
    <link rel="shortcut icon" href="<?= $base; ?>/assets/fotos/logoDP-World.ico" type="image/x-icon">
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src=" es6-promise.auto.min.js "> </script>
    <script src=" jspdf.min.js "> </script>
    <script src=" html2canvas.min.js "> </script>
    <script src=" html2pdf.bundle.min.js "> </script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
                        <img src="<?= $base; ?>/assets/fotos/logo.gif" width="70" height="50" alt="">
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav">
                            <li class="nav-item active">
                                <a class="nav-link" href="<?= $base; ?>/" style="text-align:center">Ocorrências Registradas <span class="sr-only"></span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= $base; ?>/nova_ocorrencia" style="text-align:center">Novo Registro de Ocorrência</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a style="text-align:center" class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Pesquisas
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="<?= $base; ?>/pesquisa_id">Pesquisa por ID</a>
                                    <a class="dropdown-item" href="<?= $base; ?>/pesquisa_envolvido">Pesquisa por envolvido</a>
                                    <a class="dropdown-item" href="<?= $base; ?>/pesquisa_tipo_natureza">Pesquisa por tipo e natureza</a>
                                </div>
                            </li>
                            <?php if ($usuariologado['nivel'] === "Administrador"): ?>
                                <li class="nav-item dropdown">
                                    <a style="text-align:center" class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Administrador
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                        <a style="text-align:center" class="dropdown-item" href="<?= $base; ?>/cadastro">Gerenciar usuários</a>
                                    </div>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="d-flex w-100 justify-content-end">
                <span>
                    Olá, <?= $usuariologado['nome']; ?>
                </span>
                <a style="margin-left:20px; margin-right:20px;" class="nav-link alterarSenha" href="<?= $base; ?>/alterar_senha">Alterar senha</a>
                <a class="nav-link" href="<?= $base; ?>/sair">Sair</a>
            </div>
        </div>
    </header>