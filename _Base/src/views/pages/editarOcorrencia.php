<?= $render('header', ['usuariologado' => $usuariologado]) ?>

<main style="background-color: rgba(211, 204, 204, 1)">
    <div class="container" style="background-color:  white">
        <h1 class="" style="text-align:center;margin-bottom: 40px;padding-top:10px">Edição da Ocorrência Numero: <?= $ocorrencia->id; ?></h1>

        <input type="hidden" name="idOcorrencia" value="<?= $ocorrencia->id; ?>">
        <form class="row g-3" class="formOcorrencia" enctype="multipart/form-data" method="POST" id="formEdit" action="<?= $base; ?>/editar/<?= $ocorrencia->id; ?>">
            <div class="col-md-6">
                <label for="validationServer04" class="form-label">Equipe Operacional</label>
                <select class="form-select" aria-label="Default select example" name="equipe" id="equipe">
                    <option selected><?= $ocorrencia->equipe; ?></option>
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
                    <option selected><?= $ocorrencia->forma_conhecimento; ?></option>
                    <option value="Denúncia">Denúncia</option>
                    <option value="Flagrante">Flagrante</option>
                    <option value="Prevenção">Prevenção</option>
                    <option value="Solicitação">Solicitação</option>
                </select>
            </div>

            <div class="d-flex row g-3">
                <div class="col-md-6">
                    <label for="validationServer02" class="form-label">Data da ocorrência</label>
                    <input type="date" class="form-control " id="validationServer02" value="<?= $ocorrencia->data_ocorrencia; ?>" required name="data_ocorrencia">
                </div>
                <div class="col-md-6">
                    <label for="validationServerUsername" class="form-label">Hora da ocorrência</label>
                    <div class="input-group has-validation">
                        <input type="time" class="form-control " id="validationServerUsername"
                            aria-describedby="inputGroupPrepend3 validationServerUsernameFeedback" required name="hora_ocorrencia"
                            value="<?= $ocorrencia->hora_ocorrencia; ?>">
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <label for="validationServer01" class="form-label">Título</label>
                <input type="text" class="form-control  text-break" id="validationServer01" value="<?= $ocorrencia->titulo; ?>" required name="titulo">
            </div>

            <div class="col-md-6">
                <label for="validationServer04" class="form-label">Informe a Área</label>
                <select class="form-select" aria-label="Default select example" name="area" id="areaSelectEdit">

                </select>
            </div>
            <div class="col-md-6">
                <label for="validationServer04" class="form-label">Informe o local da ocorrência</label>
                <select class="form-select" aria-label="Default select example" name="local" id="localSelectEdit">
                    <option selected><?= $ocorrencia->local; ?></option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="validationServer04" class="form-label">Tipo de natureza</label>
                <select class="form-select" aria-label="Default select example" name="tipo_natureza" id="tipo_natureza_edit">
                    <option selected><?= $ocorrencia->tipo_natureza; ?></option>
                    <option value="Falhas de tecnologia">Falhas de tecnologia</option>
                    <option value="Container">Container</option>
                    <option value="Interrupção da Operação">Interrupção da Operação</option>
                    <option value="Clandestinos">Clandestinos</option>
                    <option value="Contrabando">Contrabando</option>
                    <option value="Roubo/Furto">Roubo/Furto</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="validationServer04" class="form-label">Natureza</label>
                <select class="form-select" aria-label="Default select example" name="natureza" id="natureza_edit">
                    <option selected><?= $ocorrencia->natureza; ?></option>
                    <option value="CFTV">CFTV</option>
                    <option value="Controle de acesso">Controle de acesso</option>
                    <option value="Sistema de detecção de intrusão">Sistema de detecção de intrusão</option>
                    <option value="Servidores">Servidores</option>
                    <option value="Scanner">Scanner</option>
                    <option value="Violação">Violação</option>
                </select>
            </div>
            <div class="container mt-5">
                <h2>Envolvidos</h2>

                <!-- Pergunta se tem Envolvido -->
                <div class="mb-3">
                    <label for="temEnvolvido" class="form-label">Existem pessoas envolvidas na ocorrência?</label>
                    <select class="form-select" id="temEnvolvido" onchange="toggleEnvolvidosFields()">
                        <option value="não" <?= ($ocorrencia->envolvidosLista > 0) ?  '' : 'selected' ?>>Não</option>
                        <option value="sim" <?= ($ocorrencia->envolvidosLista > 0) ?  'selected' : '' ?>>Sim</option>
                    </select>
                </div>
                <div id="envolvidoContainer" style=" display:<?= (!empty($ocorrencia->envolvidosLista)) ?  'block' : 'none' ?>">
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
                                <input type="text" class="form-control" id="placaEdit" placeholder="Placa" placeholder="Placa" maxlength="8" pattern="[A-Za-z]{3}-\d{4}" title="A placa deve estar no formato XXX-XXXX">
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
                    <table class="table table-bordered" id="tabelaEnvolvidosEdit ">
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
                        <tbody id="envolvidosListEdit">
                            <?php if ($ocorrencia->envolvidosLista > 0) : ?>
                                <?php foreach ($ocorrencia->envolvidosLista as $index => $envolvido) : ?>
                                    <tr>
                                        <input type="hidden" name="envolvidos[<?= $index; ?>][id]" value="<?= $envolvido->id; ?>">
                                        <td><input type="hidden" name="envolvidos[<?= $index; ?>][nome]" value="<?= $envolvido->nome; ?>"><?= $envolvido->nome; ?></td>
                                        <td><input type="hidden" name="envolvidos[<?= $index; ?>][tipo_documento]" value="<?= $envolvido->tipo_de_documento; ?>"><?= $envolvido->tipo_de_documento; ?></td>
                                        <td><input type="hidden" name="envolvidos[<?= $index; ?>][numero_documento]" value="<?= $envolvido->numero_documento; ?>"><?= $envolvido->numero_documento; ?></td>
                                        <td><input type="hidden" name="envolvidos[<?= $index; ?>][envolvimento]" value="<?= $envolvido->envolvimento; ?>"><?= $envolvido->envolvimento; ?></td>
                                        <td><input type="hidden" name="envolvidos[<?= $index; ?>][vinculo]" value="<?= $envolvido->vinculo; ?>"><?= $envolvido->vinculo; ?></td>
                                        <td><input type="hidden" name="envolvidos[<?= $index; ?>][tipo_veiculo]" value="<?= $envolvido->tipo_veiculo; ?>"><?= $envolvido->tipo_veiculo; ?></td>
                                        <td><input type="hidden" name="envolvidos[<?= $index; ?>][placa]" value="<?= $envolvido->placa; ?>"><?= $envolvido->placa; ?></td>
                                        <td><button data-id="<?= $envolvido->id; ?>" type="button" class="btn btn-danger btn-sm btn-excluirEnvolvido">Remover</button></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <!-- Campos ocultos para os dados da tabela -->
                    <div id="envolvidosHiddenInputsEdit"></div>
                </div>
            </div>
            <div class="container mt-5">
                <h2>Ativos</h2>

                <!-- Pergunta se tem ativo -->
                <div class="mb-3">
                    <label for="temAtivo" class="form-label">Existem ativos da DP World envolvidos na
                        ocorrência?</label>
                    <select class="form-select" id="temAtivo" onchange="toggleAtivoFields()">
                        <option value="não" <?= ($ocorrencia->ativosLista) > 0 ?  '' : 'selected' ?>>Não</option>
                        <option value="sim" <?= ($ocorrencia->ativosLista) > 0 ?  'selected' : '' ?>>Sim</option>
                    </select>
                </div>


                <!-- Formulário e tabela de ativos (escondidos por padrão) -->
                <div id="ativoContainer" style="display:<?= (!empty($ocorrencia->ativosLista)) ?  'block' : 'none' ?>">
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
                        <tbody id="ativosListEdit">
                            <?php if ($ocorrencia->ativosLista > 0) : ?>
                                <?php foreach ($ocorrencia->ativosLista as $index => $ativo) : ?>
                                    <tr>
                                        <input type="hidden" name="ativos[<?= $index; ?>][id]" value="<?= $ativo->id; ?>">
                                        <td><input type="hidden" name="ativos[<?= $index; ?>][tipoAtivo]" value="<?= $ativo->tipo_ativo; ?>"><?= $ativo->tipo_ativo; ?></td>
                                        <td><input type="hidden" name="ativos[<?= $index; ?>][idAtivo]" value="<?= $ativo->id_ativo; ?>"><?= $ativo->id_ativo; ?></td>
                                        <td>
                                            <button data-id="<?= $ativo->id; ?>" type="button" class="btn btn-danger btn-excluirAtivo ">Remover</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <!-- Campos ocultos para os dados da tabela -->
                    <div id="AtivosHiddenInputs"></div>
                </div>
            </div>
            <div class="container mt-5">
                <h2>Editar Fotos</h2>

                <!-- Formulário para upload de fotos -->
                <div class="mb-3">
                    <label for="fotoInput" class="form-label">Selecione as fotos (JPG, JPEG ou PNG)</label>
                    <input type="file" class="form-control" id="fotoInput" multiple onchange="previewFotos()"
                        accept=".jpg, .jpeg, .png" placeholder="" name="fotos[]" value="">
                </div>

                <!-- Exibe o número de arquivos selecionados -->
                <div class="mb-3" id="fileCountContainer">
                    <p>Ficheiros selecionados: <span id="fileCount">0</span></p>
                </div>

                <!-- Carrossel de fotos (escondido por padrão) -->
                <?php
                // Verifica se $ocorrencia->fotos está vazio
                $temFotos = !empty($ocorrencia->fotosOcorrencias);
                ?>
                <div id="fotoCarrosselContainer" class="mt-4">
                    <h3>Visualizar Fotos</h3>

                    <div id="<?= $ocorrencia->id; ?>" class="carousel slide carousel-fade" data-bs-ride="carousel">
                        <div class="carousel-inner" id="carrosselFotos">
                            <?php foreach ($ocorrencia->fotosOcorrencias as $foto): ?>
                                <div class="carousel-item active d-flex justify-content-center" style="background-color: rgb(202,198,202);flex-direction:column">
                                    <img src="<?= $base; ?>/<?= $foto->url; ?>" class="d-block " alt="<?= $foto->nome; ?>" style="max-height: 500px; object-fit: cover;">
                                    <div class="delete-btn-container" style="text-align:center; margin-top: 10px;">
                                        <button data-id="<?= $foto->id; ?>" type="button" class="btn btn-danger btn-excluirFoto">Excluir</button>
                                    </div>
                                </div>
                            <?php endforeach;; ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#<?= $ocorrencia->id; ?>" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#<?= $ocorrencia->id; ?>" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>

                </div>
            </div>
            <div class="form-floating">
                <textarea class="form-control" style="min-height: 200px;" placeholder="Leave a comment here"
                    id="floatingTextarea" name="descricao"><?= $ocorrencia->descricao ?></textarea>
                <label for="floatingTextarea">Descrição da ocorrência</label>
            </div>
            <div class="form-floating">
                <textarea class="form-control" style="min-height: 200px;" placeholder="Leave a comment here"
                    id="floatingTextarea" name="acoes"><?= $ocorrencia->acoes ?></textarea>
                <label for="floatingTextarea">Ações imediatas</label>
            </div>

            <div class="col-12 d-flex justify-content-center align-items-center mb-5">
                <div class="col-4 d-flex justify-content-center">
                    <button class="btn btn-danger w-75 h-50 fw-bold"><a class="btn btn-danger print-btn" href="<?= $base ?>">Cancelar</a></button>
                </div>
                <div class="col-4 d-flex justify-content-center">
                    <button style="height: 52px" class="btn btn-success w-100     fw-bold" class="botao-enviar" type="submit" onclick="submeterFormulario()">Gravar</button>
                </div>
            </div>
        </form>
    </div>

</main>

<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('placaEdit').addEventListener('input', function(e) {
        let input = e.target.value.toUpperCase().replace(/[^A-Z0-9]/g, '');

        if (input.length > 3) {
            input = input.slice(0, 3) + '-' + input.slice(3);
        }

        e.target.value = input;
    });
</script>

<script>
    const categoriasSubcategoriasEdit = {
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

    const categorySelectEdit = document.getElementById('tipo_natureza_edit');
    const subcategorySelectEdit = document.getElementById('natureza_edit');
    const tipoNaurezaSelecionadaEdit = "<?= $ocorrencia->tipo_natureza; ?>";
    const categoriaSelecionadoEdit = "<?= $ocorrencia->natureza; ?>";

    function populateCategoriesEdit() {
        // Cria uma opção para cada categoria
        for (let category in categoriasSubcategoriasEdit) {
            const option = document.createElement('option');
            option.value = category;
            option.textContent = category;

            if (category === tipoNaurezaSelecionadaEdit) {
                option.selected = true; // Define a opção como selecionada
            }
            categorySelectEdit.appendChild(option);
        }
    }

    function populateSubcategoriesEdit(selectedCategoryEdit) {
        // Limpa as subcategorias anteriores
        subcategorySelectEdit.innerHTML = '<option value="" disabled selected>Selecione uma subcategoria</option>';

        // Verifica se a categoria selecionada existe nos dados
        if (categoriasSubcategoriasEdit[selectedCategoryEdit]) {
            // Habilita o select de subcategorias
            subcategorySelectEdit.disabled = false;

            // Cria uma opção para cada subcategoria
            categoriasSubcategoriasEdit[selectedCategoryEdit].forEach(subcategoryedit => {
                const option = document.createElement('option');
                option.value = subcategoryedit;
                option.textContent = subcategoryedit;
                if (subcategoryedit === categoriaSelecionadoEdit) {
                    option.selected = true; // Define a opção como selecionada
                }

                subcategorySelectEdit.appendChild(option);
            });
        } else {
            // Se não houver subcategorias, desabilita o select
            subcategorySelectEdit.disabled = true;
        }
    }

    // Evento que detecta mudança na categoria selecionada
    categorySelectEdit.addEventListener('change', function() {
        const selectedCategoryEdit = this.value;
        populateSubcategoriesEdit(selectedCategoryEdit);
    });

    // Inicialização
    populateCategoriesEdit();
</script>


<script>
    const locaisSublocaisEdit = {
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

    const areaSelectEdit = document.getElementById('areaSelectEdit');
    const subLocalSelectEdit = document.getElementById('localSelectEdit');

    const areaSelecionada = "<?= $ocorrencia->area; ?>";
    const localSelecionado = "<?= $ocorrencia->local; ?>";

    function populateAreasEdit() {
        // Cria uma opção para cada categoria
        for (let area in locaisSublocaisEdit) {
            const option = document.createElement('option');
            option.value = area;
            option.textContent = area;

            if (area === areaSelecionada) {
                option.selected = true; // Define a opção como selecionada
            }
            areaSelectEdit.appendChild(option);
        }
    }

    function populateSubLocaisEdit(selectedAreaEdit) {
        // Limpa as subcategorias anteriores
        subLocalSelectEdit.innerHTML = '<option value="" disabled selected>Selecione o local da ocorrencia</option>';

        // Verifica se a categoria selecionada existe nos dados
        if (locaisSublocaisEdit[selectedAreaEdit]) {
            // Habilita o select de subcategorias
            subLocalSelectEdit.disabled = false;

            // Cria uma opção para cada subcategoria
            locaisSublocaisEdit[selectedAreaEdit].forEach(subLocalEdit => {
                const option = document.createElement('option');
                option.value = subLocalEdit;
                option.textContent = subLocalEdit;
                if (subLocalEdit === localSelecionado) {
                    option.selected = true; // Define a opção como selecionada
                }
                subLocalSelectEdit.appendChild(option);
            });
        } else {
            // Se não houver subcategorias, desabilita o select
            subLocalSelectEdit.disabled = true;
        }
    }

    // Evento que detecta mudança na categoria selecionada
    areaSelectEdit.addEventListener('change', function() {
        const selectedAreaEdit = this.value;
        populateSubLocaisEdit(selectedAreaEdit);
    });

    // Inicialização
    populateAreasEdit();
</script>


<!-- Modal de exclusao de ativo -->
<div class="modal fade" id="confirmDeleteFotoModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteLabel">Confirmação de Exclusão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="fechaModalConfirmacaoExclusaoFoto()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Você tem certeza de que deseja excluir esta foto da ocorrencia?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="fechaModalConfirmacaoExclusaoFoto()">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteFotoButton">Excluir</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de exclusao de envolvido -->
<div class="modal fade" id="confirmDeleteFotoMessage" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteLabel">Confirmação de Exclusão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Ativo excluído com sucesso.
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function fechaModalConfirmacaoExclusaoFoto() {
        $('#confirmDeleteFotoModal').modal('hide'); // fecha o modal de confirmação
    }
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        let idFoto; // Variável para armazenar o ID da ocorrência

        // Captura o clique no botão de exclusão
        document.querySelectorAll('.btn-excluirFoto').forEach(button => {
            button.addEventListener('click', function() {
                idFoto = this.getAttribute('data-id'); // Captura o ID da ocorrência
                if (idFoto) {
                    $('#confirmDeleteFotoModal').modal('show'); // Exibe o modal de confirmação
                }

            });
        });

        // Confirmação de exclusão
        document.getElementById('confirmDeleteFotoButton').addEventListener('click', async function() {
            if (idFoto) {
                let data = new FormData();
                data.append('id', idFoto);

                let req = await fetch(BASE + '/excluir/foto', {
                    method: 'POST',
                    body: data
                })

                let json = await req.json()
                    .then(json => {
                        if (json && json.status === 'success') { // Verifica se 'data' não é undefined ou null
                            // Exibe o modal de confirmação
                            $('#confirmDeleteFotoModal').modal('hide');
                            $('#confirmDeleteFotoMessage').modal('show');

                            // Aguarda 3 segundos e recarrega a página
                            setTimeout(function() {
                                $('#confirmDeleteFotoMessage').modal('hide');
                                location.reload();
                            }, 2000);
                        } else {
                            alert('Erro ao excluir a ocorrência: ' + (json.message || 'Resposta inválida do servidor'));
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao excluir a ocorrência:', error);
                        alert('Ocorreu um erro ao tentar excluir a ocorrência. Por favor, tente novamente.');
                    });


            }
        });
    });
</script>

<!-- Modal de exclusao de ativo -->
<div class="modal fade" id="confirmDeleteAtivoModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteLabel">Confirmação de Exclusão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="fechaModalConfirmacaoExclusaoAtivo()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Você tem certeza de que deseja excluir este ativo da ocorrencia?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="fechaModalConfirmacaoExclusaoAtivo()">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteAtivoButton">Excluir</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de exclusao de envolvido -->
<div class="modal fade" id="confirmDeleteAtivoMessage" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteLabel">Confirmação de Exclusão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Ativo excluído com sucesso.
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function fechaModalConfirmacaoExclusaoAtivo() {
        $('#confirmDeleteAtivoModal').modal('hide'); // fecha o modal de confirmação
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let idEnvolvido; // Variável para armazenar o ID da ocorrência

        // Captura o clique no botão de exclusão
        document.querySelectorAll('.btn-excluirAtivo').forEach(button => {
            button.addEventListener('click', function() {
                idAtivo = this.getAttribute('data-id'); // Captura o ID da ocorrência
                if (idAtivo) {
                    $('#confirmDeleteAtivoModal').modal('show'); // Exibe o modal de confirmação
                }

            });
        });

        // Confirmação de exclusão
        document.getElementById('confirmDeleteAtivoButton').addEventListener('click', async function() {
            if (idAtivo) {
                let data = new FormData();
                data.append('id', idAtivo);

                let req = await fetch(BASE + '/excluir/ativo', {
                    method: 'POST',
                    body: data
                })

                let json = await req.json()
                    .then(json => {
                        if (json && json.status === 'success') { // Verifica se 'data' não é undefined ou null
                            // Exibe o modal de confirmação
                            $('#confirmDeleteAtivoModal').modal('hide');
                            $('#confirmDeleteAtivoMessage').modal('show');

                            // Aguarda 3 segundos e recarrega a página
                            setTimeout(function() {
                                $('#confirmDeleteAtivoMessage').modal('hide');
                                location.reload();
                            }, 2000);
                        } else {
                            alert('Erro ao excluir a ocorrência: ' + (json.message || 'Resposta inválida do servidor'));
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao excluir a ocorrência:', error);
                        alert('Ocorreu um erro ao tentar excluir a ocorrência. Por favor, tente novamente.');
                    });


            }
        });
    });
</script>






<!-- Modal de exclusao de envolvido -->
<div class="modal fade" id="confirmDeleteEnvolvidoModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteLabel">Confirmação de Exclusão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="fechaModalConfirmacaoExclusaoEnvoldido()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Você tem certeza de que deseja excluir este envolvido da ocorrencia?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="fechaModalConfirmacaoExclusaoEnvoldido()">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteEnvolvidoButton">Excluir</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de exclusao de envolvido -->
<div class="modal fade" id="confirmDeleteEnvolvidoMessage" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteLabel">Confirmação de Exclusão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Envolvido excluído com sucesso.
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function fechaModalConfirmacaoExclusaoEnvoldido() {
        $('#confirmDeleteEnvolvidoModal').modal('hide'); // fecha o modal de confirmação
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let idEnvolvido; // Variável para armazenar o ID da ocorrência

        // Captura o clique no botão de exclusão
        document.querySelectorAll('.btn-excluirEnvolvido').forEach(button => {
            button.addEventListener('click', function() {
                idEnvolvido = this.getAttribute('data-id'); // Captura o ID da ocorrência
                if (idEnvolvido) {
                    $('#confirmDeleteEnvolvidoModal').modal('show'); // Exibe o modal de confirmação
                }

            });
        });

        // Confirmação de exclusão
        document.getElementById('confirmDeleteEnvolvidoButton').addEventListener('click', async function() {
            if (idEnvolvido) {
                let data = new FormData();
                data.append('id', idEnvolvido);

                let req = await fetch(BASE + '/excluir/envolvido', {
                    method: 'POST',
                    body: data
                })

                let json = await req.json()
                    .then(json => {
                        if (json && json.status === 'success') { // Verifica se 'data' não é undefined ou null
                            // Exibe o modal de confirmação
                            $('#confirmDeleteEnvolvidoModal').modal('hide');
                            $('#confirmDeleteEnvolvidoMessage').modal('show');

                            // Aguarda 3 segundos e recarrega a página
                            setTimeout(function() {
                                $('#confirmDeleteEnvolvidoMessage').modal('hide');
                                location.reload();
                            }, 2000);
                        } else {
                            alert('Erro ao excluir a ocorrência: ' + (json.message || 'Resposta inválida do servidor'));
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao excluir a ocorrência:', error);
                        alert('Ocorreu um erro ao tentar excluir a ocorrência. Por favor, tente novamente.');
                    });


            }
        });
    });
</script>


<script>
    function submeterFormulario() {


        const formEdit = document.querySelector('formEdit');

        formEdit.forEach((value, key) => {
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = key;
            input.value = value;
            formEdit.appendChild(input);
        })

        for (let i = 0; i < envolvidosListEdit.rows.length; i++) {
            const cells = envolvidosListEdit.rows[i].cells;

            console.log(envolvidosListEdit.rows.length)

            adicionarHiddenInput(formEdit, `envolvidos[${i}][nome]`, cells[0].textContent);
            adicionarHiddenInput(formEdit, `envolvidos[${i}][tipoDocumento]`, cells[1].textContent);
            adicionarHiddenInput(formEdit, `envolvidos[${i}][numeroDocumento]`, cells[2].textContent);
            adicionarHiddenInput(formEdit, `envolvidos[${i}][envolvimento]`, cells[3].textContent);
            adicionarHiddenInput(formEdit, `envolvidos[${i}][vinculo]`, cells[4].textContent);
            adicionarHiddenInput(formEdit, `envolvidos[${i}][tipoVeiculo]`, cells[5].textContent);
            adicionarHiddenInput(formEdit, `envolvidos[${i}][placa]`, cells[6].textContent);
        }

        for (let i = 0; i < ativosListEdit.rows.length; i++) {
            const cells = ativosListEdit.rows[i].cells;

            adicionarHiddenInput(formEdit, `ativos[${i}][tipoAtivo]`, cells[0].textContent);
            adicionarHiddenInput(formEdit, `ativos[${i}][idAtivo]`, cells[1].textContent);

        }

        formEdit.submit()
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

    let indexEnvolvido = envolvidosListEdit.rows.length;

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

        const envolvidosListEdit = document.getElementById('envolvidosListEdit');
        const row = document.createElement('tr');

        row.innerHTML += `
               <td><input type="hidden" name="envolvidos[${indexEnvolvido}][nome]" value="${nome}">${nome}</td>
                <td><input type="hidden" name="envolvidos[${indexEnvolvido}][tipo_documento]" value="${tipoDocumento}">${tipoDocumento}</td>
                <td><input type="hidden" name="envolvidos[${indexEnvolvido}][numero_documento]" value="${numeroDocumento}">${numeroDocumento}</td>
                <td><input type="hidden" name="envolvidos[${indexEnvolvido}][envolvimento]" value="${envolvimento}">${envolvimento}</td>
                <td><input type="hidden" name="envolvidos[${indexEnvolvido}][vinculo]" value="${vinculo}">${vinculo}</td>
                <td><input type="hidden" name="envolvidos[${indexEnvolvido}][tipo_veiculo]" value="${tipoVeiculo}">${tipoVeiculo}</td>
                <td><input type="hidden" name="envolvidos[${indexEnvolvido}][placa]" value="${placa}">${placa}</td>
                <td><button type="button" class="btn btn-danger btn-sm" onclick="removeEnvolvido(this)">Remover</button></td>
            `;

        envolvidosListEdit.appendChild(row);

        // Limpa os campos após adicionar
        document.getElementById('nome').value = '';
        document.getElementById('tipoDocumento').value = '';
        document.getElementById('numeroDocumento').value = '';
        document.getElementById('vinculo').value = '';
        document.getElementById('temVeiculo').value = 'não';
        toggleVeiculoFields();
        document.getElementById('tipoVeiculo').value = '';
        document.getElementById('placa').value = '';

        // Adiciona a nova linha na tabela
        envolvidosListEdit.appendChild(row);

        // Incrementa o índice
        indexEnvolvido++;
    }

    function removeEnvolvido(button) {
        const row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }
</script>

<script>
    let indexAtivo = ativosListEdit.rows.length;

    function addAtivo() {
        const tipoAtivo = document.getElementById('tipoAtivo').value;
        const idAtivo = document.getElementById('idAtivo').value;

        if (!tipoAtivo || !idAtivo) {
            alert("Por favor, preencha todos os campos antes de adicionar.");
            return;
        }

        const ativosListEdit = document.getElementById('ativosListEdit');
        const row = document.createElement('tr');

        row.innerHTML = `
                <td><input type="hidden" name="ativos[${indexAtivo}][tipoAtivo]" value="${tipoAtivo}">${tipoAtivo}</td>
                <td><input type="hidden" name="ativos[${indexAtivo}][idAtivo]" value="${idAtivo}">${idAtivo}</td>
                <td>
                    <button type="button" class="btn btn-danger" onclick="removeAtivo(this)">Remover</button>
                </td>
            `;

        ativosListEdit.appendChild(row);

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
    document.addEventListener("DOMContentLoaded", function() {
        var fotoInput = document.getElementById('fotoInput');
        var fotosDiv = document.getElementById('fotoCarrosselContainer');

        // Função para verificar se há arquivos selecionados
        function verificarFotos() {
            if (fotoInput.files.length > 0) {
                fotosDiv.style.display = 'block';
            } else if (<?= $temFotos ? 'false' : 'true'; ?>) {
                fotosDiv.style.display = 'none';
            }
            console.log($temFotos);
        }

        // Verifica no carregamento da página
        verificarFotos();

        // Adiciona um listener ao input para verificar quando ele muda
        fotoInput.addEventListener('change', verificarFotos);
    });
</script>
<script>
    function previewFotos() {
        const fotos = document.getElementById('fotoInput').files;
        const carrosselFotos = document.getElementById('carrosselFotos');


        if (fotos.length > 0 || <?= count($ocorrencia->fotosOcorrencias) > 0 ?>) {
            document.getElementById('fotoCarrosselContainer').style.display = 'block';

            for (let i = 0; i < fotos.length; i++) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const imgElement = document.createElement('div');
                    imgElement.className = 'carousel-item' + (i === 0 ? ' active' : '');
                    imgElement.innerHTML = `
                    <img src="${event.target.result}" class="d-block w-100" alt="Foto ${i + 1}" style="max-height: 500px; object-fit: cover;">
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