<div id="filterCard">
    <!-- Card de Filtros -->
    <div class="card mb-4" id="toggleElement">
        <div class="card-header">
            <h5 class="mb-0">Filtros de Pesquisa</h5>
        </div>
        <div class="card-body">
            <form id="filter-form" method="POST" action="<?= $base; ?>/pesquisa_tipo_natureza">
                <div class="row mb-3 d-flex justify-content-center align-content-center">
                    <div class="col-md-6">
                        <label for="validationServer04" class="form-label">Tipo de natureza</label>
                        <select class="form-select" aria-label="Default select example" name="tipo_natureza" id="tipo_natureza_filtro">
                            <option value="" selected>Selecione o tipo de natureza da ocorrência </option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="validationServer04" class="form-label">Natureza</label>
                        <select class="form-select" aria-label="Default select example" name="natureza" id="natureza_filtro">
                            <option value="" selected>Selecione a natureza da ocorrência</option>
                        </select>
                    </div>
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
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100 h-75" style="margin-top: 15px">Pesquisar</button>
            </div>
        </div>
        </form>
    </div>
</div>


</div>

<script>
    const categoriasSubcategoriasFiltro = {
        "Falhas de tecnologia": ["CFTV", "Controle de acesso", "Sistema de detecção de intrusão", "Servidores", "Scanner"],
        "Container": ["Violação", "Roubo", "Furto", "Liberação incorreta", "Lacre violado", "Carregamento incorreto", "Lacre Divergente", "Transit Time Excedido", "Lacre Divergente"],
        "Interrupção da Operação": ["Conflito armado", "Terrorismo", "Greve / Protesto", "Ameaça", "Sabotagem"],
        "Clandestinos": ["Passageiros clandestinos chegando", "Passageiros clandestinos partindo", "Suspeita de passageiros clandestinos"],

        "Contrabando": ["Drogas", "Material radioativo", "Outros bens ilegais", "Armas", "Animais selvagens"],
        "Roubo / Furto": ["Ativos Terminais", "Itens pessoais"],
        "Acesso não autorizado": ["Gate", "Cerca", "Prédio", "Pátio"],
        "Tentativa de invasão": ["Gate", "Cerca", "Prédio", "Pátio"],

        "Unidade de Segurança": ["Falta de Efetivo de Segurança", "Descumprimento de procedimento", "Ato de indisciplina ou insubordinação", "Uso indevido do crachá", "Sonolência no posto", "Atitude proativa", "Uso de celular no posto", "Desatenção no posto", "Uso de celular durante condução de veiculo"],
        "Cyber Security": ["Violação Física", "Interferência de Sistemas", "Phishing"],
        "Violação de requisitos legais ou procedimentos": ["Embarque sem escaneamento", "armazenagem sem escaneamento", "Acesso ao terminal sem registro em sistema", "Saída do terminal sem registro em sistema"],
        "Acidente de trabalho": ["Fatalidade", "Ferimento", "Acidente de trânsito", "Incêndio"],

        "Fraude": ["Falsificação de documentos", "Suborno / Corrupção"],
        "Invasão do terminal": ["Gate", "Cerca", "Prédio", "Pátio"],
        "Avarias / Perdas dos ativos do Terminal": ["Dano", "Extravio", "Colisão"],
        "Avarias / Perdas dos ativos de terceiros": ["Dano", "Extravio", "Colisão"],
        "Outros": [""]
    };

    const categorySelectFiltro = document.getElementById('tipo_natureza_filtro');
    const subcategorySelectFiltro = document.getElementById('natureza_filtro');

    function populateCategoriesFiltro() {
        // Cria uma opção para cada categoria
        for (let categoryFiltro in categoriasSubcategoriasFiltro) {
            const option = document.createElement('option');
            option.value = categoryFiltro;
            option.textContent = categoryFiltro;
            categorySelectFiltro.appendChild(option);
        }
    }

    function populateSubcategoriesFiltro(selectedCategory) {
        // Limpa as subcategorias anteriores
        subcategorySelectFiltro.innerHTML = '<option value="" disabled selected>Selecione uma subcategoria</option>';

        // Verifica se a categoria selecionada existe nos dados
        if (categoriasSubcategoriasFiltro[selectedCategory]) {
            // Habilita o select de subcategorias
            subcategorySelectFiltro.disabled = false;

            // Cria uma opção para cada subcategoria
            categoriasSubcategoriasFiltro[selectedCategory].forEach(subcategory => {
                const option = document.createElement('option');
                option.value = subcategory;
                option.textContent = subcategory;
                subcategorySelectFiltro.appendChild(option);
            });
        } else {
            // Se não houver subcategorias, desabilita o select
            subcategorySelectFiltro.disabled = true;
        }
    }

    categorySelectFiltro.addEventListener('change', function() {
        const selectedCategory = this.value;
        populateSubcategoriesFiltro(selectedCategory);
    });


    populateCategoriesFiltro();
</script>