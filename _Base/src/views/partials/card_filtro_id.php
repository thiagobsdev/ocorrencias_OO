
<div  id="filterCard">
    <!-- Card de Filtros -->
    <div class="card mb-4" id="toggleElement">
        <div class="card-header">
            <h5 class="mb-0">Filtros de Pesquisa</h5>
        </div>
        <div class="card-body">
            <form id="filter-form" method="POST" action="<?= $base; ?>/pesquisa_id">
                <div class="row mb-3 d-flex justify-content-center align-content-center">
                <div class="col-md-4">
                        <label for="nome" class="form-label">Id da ocorrência</label>
                        <input type="text" class="form-control" id="id_ocorrencia" placeholder="Digite o id da ocorrencia" name="id_ocorrencia">
                    </div>
                    <div class="col-md-4 d-flex justify-content-center align-content-center align-items-md-center" >
                        <button type="submit" class="btn btn-primary w-100 h-75" style="margin-top: 15px" >Pesquisar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


</div>