<?= $render('header', ['usuariologado' => $usuariologado]) ?>

<main style="background-color: rgba(211, 204, 204, 1)">
    <div class="container" style="background-color:  white">

        <h1 class="" style="text-align:center;margin-bottom: 30px;padding-top:10px">Registros de ocorrências</h1>
        <?php if (!empty($flash) && $flash == 'Ocorrencia cadastrada com sucesso!'): ?>
            <div id="flashMessage"
                style="text-align: center;
                    color: green;
                    font-size: 34px;
                    font-weight: bold; 
                    position: fixed;
                    top: 20%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    z-index: 9999; 
                    background-color: white;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    width: 80%;
                    max-width: 500px;"
                class="flash"><?php echo $flash; ?></div>
        <?php endif; ?>
        <form class="row g-3" class="formOcorrencia" enctype="multipart/form-data" method="POST" id="formOriginal" action="<?= $base; ?>/nova_ocorrencia">
            <div class="col-md-6">
                <label for="validationServer04" class="form-label">Equipe Operacional</label>
                <select class="form-select" aria-label="Default select example" name="equipe" id="equipe">
                    <option selected></option>
                    <option value="Apoio ao Motorista">Dragão
                    <option value="Armazém da Receita Federal">Falcão</option>
                    <option value="Armazém Geral 1">Leão</option>
                    <option value="Armazém Geral 2">Tubarão</option>
                    <option value="Armazém Geral 3">Crossdocking</option>
                    <option value="Bolsão">DEPOT</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="validationServer04" class="form-label">Forma de conhecimento</label>
                <select class="form-select" aria-label="Default select example" name="forma_conhecimento" id="forma_conhecimento">
                    <option selected></option>
                    <option value="Denúncia">Denúncia</option>
                    <option value="Flagrante">Flagrante</option>
                    <option value="Prevenção">Prevenção</option>
                    <option value="Solicitação">Solicitação</option>
                </select>
            </div>


            <div class="d-flex row g-3">
                <div class="col-md-6">
                    <label for="validationServer02" class="form-label">Data da ocorrência</label>
                    <input id="data_ocorrencia" type="date" class="form-control " id="validationServer02" value="" required name="data_ocorrencia">
                </div>
                <div class="col-md-6">
                    <label for="validationServerUsername" class="form-label">Hora da ocorrência</label>
                    <div class="input-group has-validation">
                        <input type="time" class="form-control " id="validationServerUsername"
                            aria-describedby="inputGroupPrepend3 validationServerUsernameFeedback" required name="hora_ocorrencia">
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <label for="validationServer01" class="form-label">Título</label>
                <input type="text" class="form-control  text-break" id="validationServer01" value="" required name="titulo">
            </div>

            <div class="col-md-6">
                <label for="validationServer04" class="form-label">Informe a Área</label>
                <select class="form-select" aria-label="Default select example" name="area" id="areaSelect">
                    <option value="" selected>Selecione a area da ocorrencia</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="validationServer04" class="form-label">Informe o local da ocorrência</label>
                <select class="form-select" aria-label="Default select example" name="local" id="localSelect">
                    <option value="" selected>Selecione o local da ocorrência</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="validationServer04" class="form-label">Tipo de natureza</label>
                <select class="form-select" aria-label="Default select example" name="tipo_natureza" id="tipo_natureza">
                    <option value="" selected>Selecione o tipo de natureza da ocorrência </option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="validationServer04" class="form-label">Natureza</label>
                <select class="form-select" aria-label="Default select example" name="natureza" id="natureza">
                    <option value="" selected>Selecione a natureza da ocorrência</option>
                </select>
            </div>
            <div class="container mt-5">
                <h2>Envolvidos</h2>

                <!-- Pergunta se tem ativo -->
                <div class="mb-3">
                    <label for="temEnvolvido" class="form-label">Existem pessoas envolvidas na ocorrência?</label>
                    <select class="form-select" id="temEnvolvido" onchange="toggleEnvolvidosFields()">
                        <option value="não" selected>Não</option>
                        <option value="sim">Sim</option>
                    </select>
                </div>
                <div id="envolvidoContainer" style="display: none;">
                    <!-- Formulário para adicionar envolvido -->
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="nome" placeholder="Nome">
                            </div>
                            <div class="col-md-3">
                                <label for="tipoDocumento" class="form-label">Tipo de Documento</label>
                                <select class="form-select" id="tipoDocumento">
                                    <option selected>Escolher...</option>
                                    <option value="RG">RG</option>
                                    <option value="CPF">CPF</option>
                                    <option value="CNH">CNH</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="numeroDocumento" class="form-label">Número do Documento</label>
                                <input type="text" class="form-control" id="numeroDocumento" placeholder="Número">
                            </div>
                            <div class="col-md-3">
                                <label for="envolvimento" class="form-label">Envolvimento</label>
                                <select class="form-select" aria-label="Default select example" class="form-control"
                                    id="envolvimento">
                                    <option selected></option>
                                    <option value="Indefinido">Indefinido</option>
                                    <option value="Causador">Causador</option>
                                    <option value="Testemunha">Testemunha
                                    </option>
                                    <option value="Vitima">Vitima</option>
                                </select>
                            </div>
                            <div class="col-md-2 mt-2">

                                <label for="vinculo" class="form-label">Vínculo</label>
                                <select class="form-select" aria-label="Default select example" class="form-control"
                                    id="vinculo">
                                    <option selected></option>
                                    <option value="Integrante">Integrante</option>
                                    <option value="Prestador de Serviço">Prestador de Serviço</option>
                                    <option value="Visitante">Visitante
                                    </option>
                                    <option value="Autoridade">Autoridade</option>
                                    <option value="Tripulante">Tripulante</option>
                                    <option value="Motorista">Motorista</option>
                                    <option value="Trabalhador Avulso (OGMO)">Trabalhador Avulso (OGMO)</option>
                                </select>
                            </div>
                            <div class="col-md-2 mt-2">
                                <label for="temVeiculo" class="form-label">Possui Veículo?</label>
                                <select class="form-select" id="temVeiculo" onchange="toggleVeiculoFields()">
                                    <option value="não" selected>Não</option>
                                    <option value="sim">Sim</option>
                                </select>
                            </div>
                            <div class="col-4 md-4 mt-2" id="veiculoFields" style="display: none;">
                                <label for="tipoVeiculo" class="form-label">Tipo de Veículo</label>
                                <select class="form-select" id="tipoVeiculo">
                                    <option selected>Escolher...</option>
                                    <option value="Carro">Carro</option>
                                    <option value="Moto">Moto</option>
                                    <option value="Caminhão">Caminhão</option>
                                </select>
                            </div>
                            <div class="col-4 md-4 mt-2" id="veiculoPlaca" style="display: none;">
                                <label for="placa" class="form-label">Placa</label>
                                <input type="text" class="form-control" id="placa" placeholder="Placa" maxlength="8" pattern="[A-Za-z]{3}-\d{4}" title="A placa deve estar no formato XXX-XXXX">
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-5">
                            <div class="col-md-4">
                                <button type="button" class="btn btn-success w-100"
                                    onclick="addEnvolvido()">Adicionar</button>
                            </div>
                        </div>
                    </div>

                    <!-- Tabela de envolvidos -->
                    <h3 class="mt-4">Lista de Envolvidos</h3>
                    <table class="table table-bordered" id="tabelaEnvolvidos ">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Tipo de Documento</th>
                                <th>Número do Documento</th>
                                <th>Envolvimento</th>
                                <th>Vínculo</th>
                                <th>Tipo de Veículo</th>
                                <th>Placa</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="envolvidosList">
                            <!-- Linhas adicionadas dinamicamente -->
                        </tbody>
                    </table>
                    <!-- Campos ocultos para os dados da tabela -->
                    <div id="envolvidosHiddenInputs"></div>
                </div>
            </div>
            <div class="container mt-5">
                <h2>Ativos</h2>

                <!-- Pergunta se tem ativo -->
                <div class="mb-3">
                    <label for="temAtivo" class="form-label">Existem ativos da DP World envolvidos na
                        ocorrência?</label>
                    <select class="form-select" id="temAtivo" onchange="toggleAtivoFields()">
                        <option value="não" selected>Não</option>
                        <option value="sim">Sim</option>
                    </select>
                </div>


                <!-- Formulário e tabela de ativos (escondidos por padrão) -->
                <div id="ativoContainer" style="display: none;">
                    <!-- Formulário para adicionar ativo -->
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="tipoAtivo" class="form-label">Tipo de Ativo</label>
                                <select class="form-select" id="tipoAtivo" name="tipoAtivo">
                                    <option selected>Escolher...</option>
                                    <option value="QC">QC</option>
                                    <option value="RTG">RTG</option>
                                    <option value="ITV">ITV</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="idAtivo" class="form-label">ID do Ativo</label>
                                <input type="text" class="form-control" id="idAtivo" placeholder="ID do Ativo">
                            </div>
                            <div class="col-md-4 align-self-end">
                                <button type="button" class="btn btn-success w-100"
                                    onclick="addAtivo()">Adicionar</button>
                            </div>
                        </div>
                    </div>

                    <!-- Tabela de ativos -->
                    <h3 class="mt-4">Lista de Ativos</h3>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Tipo de Ativo</th>
                                <th>ID do Ativo</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="ativosList">
                            <!-- Linhas adicionadas dinamicamente -->
                        </tbody>
                    </table>
                    <!-- Campos ocultos para os dados da tabela -->
                    <div id="AtivosHiddenInputs"></div>
                </div>
            </div>
            <div class="container mt-5">
                <h2>Adicionar Fotos</h2>

                <!-- Formulário para upload de fotos -->
                <div class="mb-3">
                    <label for="fotoInput" class="form-label">Selecione as fotos (JPG, JPEG ou PNG)</label>
                    <input type="file" class="form-control" id="fotoInput" multiple onchange="previewFotos()"
                        accept=".jpg, .jpeg, .png" placeholder="" name="fotos[]">
                </div>

                <!-- Exibe o número de arquivos selecionados -->
                <div class="mb-3" id="fileCountContainer">
                    <p>Ficheiros selecionados: <span id="fileCount">0</span></p>
                </div>

                <!-- Carrossel de fotos (escondido por padrão) -->
                <div id="fotoCarrosselContainer" class="mt-4" style="display: none;">
                    <h3>Visualizar Fotos</h3>
                    <div id="fotoCarrossel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                        <div class="carousel-inner" id="carrosselFotos">
                            <!-- Fotos adicionadas dinamicamente -->
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#fotoCarrossel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#fotoCarrossel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Próximo</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="form-floating">
                <textarea class="form-control" style="min-height: 200px;" placeholder="Leave a comment here"
                    id="floatingTextarea" name="descricao"></textarea>
                <label for="floatingTextarea">Descrição da ocorrência</label>
            </div>
            <div class="form-floating">
                <textarea class="form-control" style="min-height: 200px;" placeholder="Leave a comment here"
                    id="floatingTextarea" name="acoes"></textarea>
                <label for="floatingTextarea">Ações imediatas</label>
            </div>

            <div class="col-12 d-flex justify-content-center align-items-center mb-5">
                <div class="col-4 d-flex justify-content-center">
                    <button class="btn btn-danger w-75 fw-bold" type="submit">Cancelar</button>
                </div>
                <div class="col-4 d-flex justify-content-center">
                    <button class="btn btn-success w-75 fw-bold" class="botao-enviar" type="submit" onclick="submeterFormulario()">Gravar</button>
                </div>
            </div>
        </form>
    </div>
</main>
<script>
    document.getElementById('placa').addEventListener('input', function(e) {
        let input = e.target.value.toUpperCase().replace(/[^A-Z0-9]/g, '');

        if (input.length > 3) {
            input = input.slice(0, 3) + '-' + input.slice(3);
        }

        e.target.value = input;
    });
</script>
<script>
    const locaisSublocais = {
        "Área 1": ["Apoio ao Motorista", "Armazém da Receita Federal", "Armazém Geral 1", "Armazém Geral 2", "Armazém Geral 3",
            "Bolsão", "Castelo D'Agua - Marítima", "Castelo D'Agua - Portaria Principal", "CCOS", "Communication Room - 1 Andar",
            "Communication Room - 2º Andar", "Communication Room - Térreo", "Data Center", "Depot", "Eletrocentro Nº 006 - Gate",
            "Eletrocentro Nº 006.1 - Depot", "Escritório do Armazém RFB", "Gate Operacional", "OCR In", "OCR Out", "Pátio do Armazém Geral",
            "Portaria Marítima", "Portaria Principal", "Prédio Administrativo", "Refeitório Administrativo", "Sala da Unidade de Segurança",
            "Scanner P60", "Vestiário - Administrativo", "Posto P10", "Vistoria 17 pontos"
        ],

        "Área 2": ["Armazém Vertere", "Canteiro de Obras Suzano", "Castelo D'Agua - Vertere", "Central de Contra-Incêndio",
            "Communication Room - Térreo", "Eletrocentro Nº 005 - Vertere", "Escritório Vertere", "Gate Ferroviário Vertere",
            "Linha Férrea", "Pera Ferroviária", "Portaria Vertere", "Vestiário Vertere"
        ],

        "Área 3": ["Almoxarifado", "Ambulatório", "Área de Expansão", "Armazém Logístico (AZ Log)", "Berço 1", "Berço 2", "Berço 3", "Berço 4",
            "Castelo D'Agua - Workshop", "Central de Contra-Incêndio", "Central de Resíduos", "Centro de Condicionamento Físico", "Communication Room - 1º Andar",
            "Data Center", "Dique de Contenção", "Eletrocentro Az Log", "Eletrocentro Nº 001 - Reefer", "Eletrocentro Nº 003 - QC 1 a 3", "Eletrocentro Nº 004 - QC 4 a 6",
            "Eletrocentro Nº 008 - Workshop", "Gate Ferroviário", "Lavador de Equipamentos", "Linha Férrea", "Oficina da Manutenção",
            "Pátio de Contêineres - Bloco 1", "Pátio de Contêineres - Bloco 2", "Pátio de Contêineres - Bloco 3", "Pátio Ferroviário", "Posto de Combustível",
            "Refeitório Operacional", "Scanner EBCO", "Scanner T60", "Subestação Principal", "Vestiário Operacional", "Workshop"
        ],

        "Pontes e Viadutos": ["Ponte Área 1 - 3", "Ponte Área 1 - 2", "Viaduto Área 2 - 3 (Vertere)"],

        "Área Externa": ["Base Área de Santos", "Canal de Navegação", "Estada Particular da CODESP", "Ilha Barnabé",
            "Linha de Alta Tensão 138kVA", "Linha Férrea", "Margem Direita", "Navio", "Píer Santos", "Rio Diana", "Rio Sandi", "Rodovia Conego Domenico Rangoni"
        ],
        "Outras Localizações": ["Outros"],

    };

    const areaSelect = document.getElementById('areaSelect');
    const subLocalSelect = document.getElementById('localSelect');

    function populateAreas() {
        // Cria uma opção para cada categoria
        for (let area in locaisSublocais) {
            const option = document.createElement('option');
            option.value = area;
            option.textContent = area;
            areaSelect.appendChild(option);
        }
    }

    function populateSubLocais(selectedArea) {
        // Limpa as subcategorias anteriores
        subLocalSelect.innerHTML = '<option value="" disabled selected>Selecione o local da ocorrencia</option>';

        // Verifica se a categoria selecionada existe nos dados
        if (locaisSublocais[selectedArea]) {
            // Habilita o select de subcategorias
            subLocalSelect.disabled = false;

            // Cria uma opção para cada subcategoria
            locaisSublocais[selectedArea].forEach(subLocal => {
                const option = document.createElement('option');
                option.value = subLocal;
                option.textContent = subLocal;
                subLocalSelect.appendChild(option);
            });
        } else {
            // Se não houver subcategorias, desabilita o select
            subLocalSelect.disabled = true;
        }
    }

    // Evento que detecta mudança na categoria selecionada
    areaSelect.addEventListener('change', function() {
        const selectedArea = this.value;
        populateSubLocais(selectedArea);
    });

    // Inicialização
    populateAreas();
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const flashMessage = document.getElementById('flashMessage');
        if (flashMessage) {
            setTimeout(function() {
                flashMessage.style.display = 'none';
            }, 2000);
        }
    });
</script>

<script>
    const categoriasSubcategorias = {
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

    const categorySelect = document.getElementById('tipo_natureza');
    const subcategorySelect = document.getElementById('natureza');

    function populateCategories() {
        // Cria uma opção para cada categoria
        for (let category in categoriasSubcategorias) {
            const option = document.createElement('option');
            option.value = category;
            option.textContent = category;
            categorySelect.appendChild(option);
        }
    }

    function populateSubcategories(selectedCategory) {
        // Limpa as subcategorias anteriores
        subcategorySelect.innerHTML = '<option value="" disabled selected>Selecione uma subcategoria</option>';

        // Verifica se a categoria selecionada existe nos dados
        if (categoriasSubcategorias[selectedCategory]) {
            // Habilita o select de subcategorias
            subcategorySelect.disabled = false;

            // Cria uma opção para cada subcategoria
            categoriasSubcategorias[selectedCategory].forEach(subcategory => {
                const option = document.createElement('option');
                option.value = subcategory;
                option.textContent = subcategory;
                subcategorySelect.appendChild(option);
            });
        } else {
            // Se não houver subcategorias, desabilita o select
            subcategorySelect.disabled = true;
        }
    }

    // Evento que detecta mudança na categoria selecionada
    categorySelect.addEventListener('change', function() {
        const selectedCategory = this.value;
        populateSubcategories(selectedCategory);
    });

    // Inicialização
    populateCategories();
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const flashMessage = document.getElementById('flashMessage');
        if (flashMessage) {
            setTimeout(function() {
                flashMessage.style.display = 'none';
            }, 2000);
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
        modal.show();
    });
</script>
<script>
    function setMaxDate() {
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0');

        const day = String(today.getDate()).padStart(2, '0');
        const maxDate = `${year}-${month}-${day}`;
        const dateInput = document.getElementById('data_ocorrencia');
        dateInput.setAttribute('max', maxDate);
    }

    // Chama a função para definir o valor máximo
    setMaxDate();
</script>

<script>
    function submeterFormulario() {


        const formOriginal = document.querySelector('formOriginal');

        formOriginal.forEach((value, key) => {
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = key;
            input.value = value;
            formOriginal.appendChild(input);
        })

        for (let i = 0; i < envolvidosList.rows.length; i++) {
            const cells = envolvidosList.rows[i].cells;

            adicionarHiddenInput(formOriginal, `envolvidos[${i}][nome]`, cells[0].textContent);
            adicionarHiddenInput(formOriginal, `envolvidos[${i}][tipoDocumento]`, cells[1].textContent);
            adicionarHiddenInput(formOriginal, `envolvidos[${i}][numeroDocumento]`, cells[2].textContent);
            adicionarHiddenInput(formOriginal, `envolvidos[${i}][envolvimento]`, cells[3].textContent);
            adicionarHiddenInput(formOriginal, `envolvidos[${i}][vinculo]`, cells[4].textContent);
            adicionarHiddenInput(formOriginal, `envolvidos[${i}][tipoVeiculo]`, cells[5].textContent);
            adicionarHiddenInput(formOriginal, `envolvidos[${i}][placa]`, cells[6].textContent);
        }

        for (let i = 0; i < ativosList.rows.length; i++) {
            const cells = ativosList.rows[i].cells;

            adicionarHiddenInput(formOriginal, `ativos[${i}][tipoAtivo]`, cells[0].textContent);
            adicionarHiddenInput(formOriginal, `ativos[${i}][idAtivo]`, cells[1].textContent);

        }

        formOriginal.submit()
    }

    function adicionarHiddenInput(form, name, value) {
        const input = document.createElement("input");
        input.type = "hidden";
        input.name = name;
        input.value = value;
        form.appendChild(input);
    }
</script>


<script>
    function toggleVeiculoFields() {
        const temVeiculo = document.getElementById('temVeiculo').value;
        const veiculoFields = document.getElementById('veiculoFields');
        const veiuloPlaca = document.getElementById('veiculoPlaca');
        veiculoFields.style.display = temVeiculo === 'sim' ? 'block' : 'none';
        veiuloPlaca.style.display = temVeiculo === 'sim' ? 'block' : 'none';
    }

    let indexEnvolvido = 0;

    function addEnvolvido() {


        const nome = document.getElementById('nome').value;
        const tipoDocumento = document.getElementById('tipoDocumento').value;
        const numeroDocumento = document.getElementById('numeroDocumento').value;
        const vinculo = document.getElementById('vinculo').value;
        const envolvimento = document.getElementById('envolvimento').value
        const temVeiculo = document.getElementById('temVeiculo').value;
        const tipoVeiculo = temVeiculo === 'sim' ? document.getElementById('tipoVeiculo').value : '';
        const placa = temVeiculo === 'sim' ? document.getElementById('placa').value : '';

        if (!nome || !tipoDocumento || !envolvimento || !numeroDocumento || !vinculo || (temVeiculo === 'sim' && (!tipoVeiculo || !placa))) {
            alert("Por favor, preencha todos os campos obrigatórios antes de adicionar.");
            return;
        }

        const envolvidosList = document.getElementById('envolvidosList');
        const row = document.createElement('tr');

        row.innerHTML = `
               <td><input type="hidden" name="envolvidos[${indexEnvolvido}][nome]" value="${nome}">${nome}</td>
                <td><input type="hidden" name="envolvidos[${indexEnvolvido}][tipo_documento]" value="${tipoDocumento}">${tipoDocumento}</td>
                <td><input type="hidden" name="envolvidos[${indexEnvolvido}][numero_documento]" value="${numeroDocumento}">${numeroDocumento}</td>
                <td><input type="hidden" name="envolvidos[${indexEnvolvido}][envolvimento]" value="${envolvimento}">${envolvimento}</td>
                <td><input type="hidden" name="envolvidos[${indexEnvolvido}][vinculo]" value="${vinculo}">${vinculo}</td>
                <td><input type="hidden" name="envolvidos[${indexEnvolvido}][tipo_veiculo]" value="${tipoVeiculo}">${tipoVeiculo}</td>
                <td><input type="hidden" name="envolvidos[${indexEnvolvido}][placa]" value="${placa}">${placa}</td>
                <td><button type="button" class="btn btn-danger btn-sm" onclick="removeEnvolvido(this)">Remover</button></td>
            `;

        envolvidosList.appendChild(row);

        // Limpa os campos após adicionar
        document.getElementById('nome').value = '';
        document.getElementById('tipoDocumento').value = '';
        document.getElementById('numeroDocumento').value = '';
        document.getElementById('vinculo').value = '';
        document.getElementById('envolvimento').value = '';
        document.getElementById('temVeiculo').value = 'não';
        toggleVeiculoFields();
        document.getElementById('tipoVeiculo').value = '';
        document.getElementById('placa').value = '';

        // Adiciona a nova linha na tabela
        envolvidosList.appendChild(row);

        // Incrementa o índice
        indexEnvolvido++;
    }

    function removeEnvolvido(button) {
        const row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }
</script>

<script>
    let indexAtivo = 0;

    function addAtivo() {
        const tipoAtivo = document.getElementById('tipoAtivo').value;
        const idAtivo = document.getElementById('idAtivo').value;

        if (!tipoAtivo || !idAtivo) {
            alert("Por favor, preencha todos os campos antes de adicionar.");
            return;
        }

        const ativosList = document.getElementById('ativosList');
        const row = document.createElement('tr');

        row.innerHTML = `
                <td><input type="hidden" name="ativos[${indexAtivo}][tipoAtivo]" value="${tipoAtivo}">${tipoAtivo}</td>
                <td><input type="hidden" name="ativos[${indexAtivo}][idAtivo]" value="${idAtivo}">${idAtivo}</td>
                <td>
                    <button type="button" class="btn btn-danger" onclick="removeAtivo(this)">Remover</button>
                </td>
            `;

        ativosList.appendChild(row);

        // Limpa os campos após adicionar
        document.getElementById('tipoAtivo').value = '';
        document.getElementById('idAtivo').value = '';

        // Incrementa o índice
        indexAtivo++;
    }

    function toggleEnvolvidosFields() {
        const temEnvolvido = document.getElementById('temEnvolvido').value;
        const envolvidoContainer = document.getElementById('envolvidoContainer');
        envolvidoContainer.style.display = temEnvolvido === 'sim' ? 'block' : 'none';
    }

    function toggleAtivoFields() {
        const temAtivo = document.getElementById('temAtivo').value;
        const ativoContainer = document.getElementById('ativoContainer');
        ativoContainer.style.display = temAtivo === 'sim' ? 'block' : 'none';
    }



    function removeAtivo(button) {
        const row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }
</script>
<script>
    function previewFotos() {
        const fotos = document.getElementById('fotoInput').files;
        const carrosselFotos = document.getElementById('carrosselFotos');
        carrosselFotos.innerHTML = ''; // Limpa o carrossel existente

        if (fotos.length > 0) {
            document.getElementById('fotoCarrosselContainer').style.display = 'block';

            for (let i = 0; i < fotos.length; i++) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const imgElement = document.createElement('div');
                    imgElement.className = 'd-flex justify-content-center carousel-item' + (i === 0 ? ' active' : '')
                    imgElement.style.flexDirection = "column"
                    imgElement.style.backgroundColor = "rgb(202,198,202)"
                    imgElement.style.textAlign = "center"
                    imgElement.innerHTML = `
                    <img src="${event.target.result}" class="d-block  " alt="Foto ${i + 1}" style="max-height: 500px; object-fit: cover;" >
                    <div class="delete-btn-container"  style="text-align:center; margin-top: 10px;">
                        <button type="button" class="btn btn-danger" onclick="removeFoto(this)">Excluir</button>
                    </div>
                `;
                    carrosselFotos.appendChild(imgElement);
                }
                reader.readAsDataURL(fotos[i]);

            }
        } else {
            document.getElementById('fotoCarrosselContainer').style.display = 'none';
        }

        function alterarValor() {

            const span = document.getElementById('fotoInput');
            span.textContent = '';
        }
    }

    function removeFoto(button) {
        const item = button.closest('.carousel-item');
        const carousel = document.querySelector('#fotoCarrossel .carousel-inner');

        const isActive = item.classList.contains('active');
        item.remove();

        const items = carousel.querySelectorAll('.carousel-item');
        if (items.length > 0) {
            if (isActive) {
                // Se o item removido era o ativo, ativar o próximo ou o anterior
                if (item.nextElementSibling) {
                    item.nextElementSibling.classList.add('active');
                } else {
                    items[0].classList.add('active');
                }
            }
        } else {
            // Se não houver mais fotos, ocultar o carrossel
            document.getElementById('fotoCarrosselContainer').style.display = 'none';
        }

        // Atualiza o contador de arquivos após remoção
        document.getElementById('fileCount').textContent = items.length;
    }
</script>

</body>

</html>