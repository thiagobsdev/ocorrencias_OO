<?= $render('header', ['usuariologado' => $usuariologado]) ?>


<div class="d-flex">

    <div class="container-xxl my-5">


        <h1 class="text-center mt-xxl-5 mt-xl-5 mt-md-5 mt-lg-5 mt-md-4 mt-5 mb-5">OCORRÊNCIAS SEGURANÇA PATRIMONIAL</h1>
        <!-- Toggle para o Card de Filtros -->
        <?= $render('card_filtro_envolvidos'); ?>

    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src=" es6-promise.auto.min.js "> </script>
    <script src=" jspdf.min.js "> </script>
    <script src=" html2canvas.min.js "> </script>
    <script src=" html2pdf.bundle.min.js "> </script>

    <script>
        document.getElementById('toggleButton').addEventListener('click', function() {
            if (element.classList.contains('collapse')) {
                element.classList.remove('collapse');
                element.classList.add('collapse.show');
                // Para garantir que a transição funcione corretamente, altere a altura antes de ocultar
                setTimeout(function() {
                    element.style.height = '0';
                }, 500); // 500ms deve corresponder à duração da transição
            } else {
                element.classList.remove('collapse.show');
                element.classList.add('collapse');
                element.style.height = 'auto';
            }
        });
    </script>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('collapsed');
            document.getElementById('content').classList.toggle('collapsed');
        });
    </script>
    <script>

    </script>
    </body>

    </html>