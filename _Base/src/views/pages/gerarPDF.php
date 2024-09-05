<?php




use Dompdf\Dompdf;

$dompdf = new Dompdf(['enable_remote' => true])




?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ocorrências Segurança Patrimonial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= $base; ?>/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $base; ?>/styles.css">
    <link rel="stylesheet" href="<?= $base; ?>/ocorrencia-css.css">
    <link rel="shortcut icon" href="<?= $base; ?>/assets/fotos/logoDP-World.ico" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script type="text/javascript">
        const BASE = "<?= $base; ?>"
    </script>
    <style>
        #pdf-content {
            width: 210mm;
            /* Largura de uma página A4 */

            padding: 10mm;
            background-color: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        }

        #pdf-images {
            display: none;
            /* Ocultar imagens na visualização principal */
        }
    </style>
</head>

<div class="d-flex" id="pdf-content">

    <div class="container-sm my-5">
        <div class="card mb-4 mb-3">
            <div class="container">
                <div style=" width: 100%; display:flex; justify-content:center; align-content: center; ">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <img src="<?= $base; ?>/assets/fotos/logoDPWPDF.png" alt="" style="margin-left: 30px">
                            </div>
                            <div class="col">
                                <h3 style="font-size: 16px; text-align:center;width: 100%; margin-top: 10px ;"> REGISTRO DE OCORRÊNCIA SEGURANÇA PATRIMONIAL</h3>
                            </div>
                            <div class="col">
                                <div style=" width: 100%; display: flex; align-items: end ;flex-direction:column; margin-right: 10px; margin-top: 10px">
                                    <div>
                                        <strong id="ocorrencia-id" data-id="<?= $ocorrencia->id; ?>">ID:</strong><?= " " . $ocorrencia->id . " "; ?>| <strong>Data:</strong> <?= " " . DateTime::createFromFormat('Y-m-d', $ocorrencia->data_ocorrencia)->format('d/m/Y') . " "; ?> |
                                        <strong>Hora:</strong> <?= " " . $ocorrencia->hora_ocorrencia . " "; ?>
                                    </div>
                                    <strong>Registrado por:</strong> <?= " " . $ocorrencia->usuario->nome . " "; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body ocorrencia-content" id="ocorrencia-001">
                <h5 class="card-title" style="text-align:center"><?= " " . $ocorrencia->titulo . " "; ?></h5>
                <p class="card-text">
                    <strong>Área:</strong> <?= " " . $ocorrencia->area . " "; ?><br>
                    <strong>Local:</strong> <?= " " . $ocorrencia->local . " "; ?><br>
                    <strong>Tipo:</strong> <?= " " . $ocorrencia->tipo_natureza . " "; ?><br>
                    <strong>Natureza:</strong> <?= " " . $ocorrencia->natureza . " "; ?>
                </p>

                <!-- Informações do Ativo -->

                <h6>Ativos:</h6>
                <?php if (!empty($ocorrencia->ativosLista)) : ?>
                    <table class="table table-light table-striped ">
                        <thead>
                            <tr>
                                <th>Tipo de ativo</th>
                                <th>Identificação do ativo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($ocorrencia->ativosLista as $ativo): ?>
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

                <?php if (!empty($ocorrencia->envolvidosLista)) : ?>
                    <table class="table table-light table-striped ">
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
                            <?php foreach ($ocorrencia->envolvidosLista as $envolvido): ?>
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
                <p class="card-text"><?= nl2br($ocorrencia->descricao) . " "; ?>.</p>

                <!-- Ações Tomadas -->
                <h6 class="">Ações Tomadas:</h6>
                <p class="card-text"><?= nl2br($ocorrencia->acoes) . " "; ?>.</p>


                <!-- Fotos -->
                <h6>Fotos:</h6>
                <div class="container" id="pdf-images" style="display: grid; grid-template-columns: auto auto;grid-column-gap: 10px;grid-row-gap: 10px;">
                    <?php if( !empty($ocorrencia->fotosOcorrencias)):?>
                        <?php foreach ($ocorrencia->fotosOcorrencias as $foto): ?>
                            <img style="width:100%" src="<?= $base; ?>/<?= $foto->url; ?>" alt="">
                        <?php endforeach; ?>
                    <?php endif;?>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Inclua as bibliotecas antes de qualquer código JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
    window.addEventListener('load', function() {
        const element = document.getElementById('pdf-content');
        const imagesElement = document.getElementById('pdf-images');
        const ocorrenciaElement = document.getElementById('ocorrencia-id');
        const ocorrenciaId = ocorrenciaElement.getAttribute('data-id');

        html2canvas(element, {
            scale: 2, // Aumenta a escala para melhor resolução
            useCORS: true, // Caso esteja utilizando imagens de domínios externos
        }).then(canvas => {
            const imgData = canvas.toDataURL('image/png');

            // Acesso correto ao jsPDF
            const {
                jsPDF
            } = window.jspdf;
            const pdf = new jsPDF('p', 'mm', 'a4'); // Orientação retrato, unidade em milímetros, formato A4

            const imgWidth = 210;
            const pageHeight = 297;
            const imgHeight = canvas.height * imgWidth / canvas.width;
            let heightLeft = imgHeight;

            let position = 0;



            pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
            heightLeft -= pageHeight;

            while (heightLeft >= 0) {
                position = heightLeft - imgHeight;
                pdf.addPage();
                pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;
            }
            const nomeArquivo = `ocorrencia_${ocorrenciaId}.pdf`;

            pdf.save(nomeArquivo);
        }).catch(error => console.error('Erro ao gerar o PDF:', error));
    });
</script>
</body>

</html>