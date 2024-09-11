<div id="filterCard">
    <!-- Card de Filtros -->
    <div class="card mb-4" id="toggleElement">
        <div class="card-header">
            <h5 class="mb-0">Filtros de Pesquisa</h5>
        </div>
        <div class="card-body">
            <form id="filter-form" method="POST" action="<?= $base; ?>pesquisa_envolvido_action.php">
                <div class="row mb-3 d-flex justify-content-center align-content-center">
                    <div class="col-md-4">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" placeholder="Nome" name="nomeEnvolvido">
                    </div>
                    <div class="col-md-4">
                        <label for="numeroDocumento" class="form-label">Número do Documento</label>
                        <input type="text" class="form-control" id="numeroDocumento" placeholder="Número" require name="numeroDocumentoEnvolvido">
                    </div>
                    <div class="col-md-4">
                        <label for="envolvimento" class="form-label">Envolvimento</label>
                        <select class="form-select" aria-label="Default select example" class="form-control"
                            id="envolvimento" name="envolvimentoEnvolvido">
                            <option selected></option>
                            <option value="Indefinido">Indefinido</option>
                            <option value="Causador">Causador</option>
                            <option value="Testemunha">Testemunha
                            </option>
                            <option value="Vitima">Vitima</option>
                        </select>
                    </div>
                    <div class="row mb-3 d-flex justify-content-center align-content-center">
                        <div class="col-md-6">
                            <label for="data" class="form-label">Data inicio</label>
                            <input type="date" class="form-control" id="data" name="dataInicio">
                        </div>
                        <div class="col-md-6">
                            <label for="data" class="form-label">Data fim</label>
                            <input type="date" class="form-control" id="data" name="dataFim">
                        </div>
                    </div>
                </div>

                <div class="row mb-3 d-flex justify-content-center align-content-center">

                </div>
                <div class="row mb-3 d-flex justify-content-center align-content-center">
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100 h-75" style="margin-top: 15px">Pesquisar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


</div>