<button class="btn btn-primary mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#filterCard" aria-expanded="false" aria-controls="filterCard" id="toggleButton">
    Filtros de Pesquisa
</button>
<div class="collapse" id="filterCard">
    <!-- Card de Filtros -->
    <div class="card mb-4" id="toggleElement">
        <div class="card-header">
            <h5 class="mb-0">Filtros de Pesquisa</h5>
        </div>
        <div class="card-body">
            <form id="filter-form" method="GET" action="<?= $base; ?>/pesquisa_datas">
                <div class="row mb-3 d-flex justify-content-center align-content-center">
                    <div class="col-md-4">
                        <label for="data" class="form-label">Data inicio</label>
                        <input type="date" class="form-control" id="data" name="dataInicio">
                    </div>
                    <div class="col-md-4">
                        <label for="data" class="form-label">Data fim</label>
                        <input type="date" class="form-control" id="data" name="dataFim">
                    </div>
                    <div class="col-md-4 d-flex justify-content-center align-content-center align-items-md-center" >
                        <button type="submit" class="btn btn-primary w-100 h-75" style="margin-top: 15px" >Pesquisar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


</div>