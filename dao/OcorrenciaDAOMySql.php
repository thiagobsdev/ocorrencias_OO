<?php

require_once 'models/Ocorrencia.php';
require_once 'dao/UserDAOMySql.php';
require_once 'dao/AtivoDAOMySql.php';
require_once 'dao/EnvolvidoDAOMySql.php';
require_once 'dao/FotoDAOMySql.php';



use src\models\Ocorrencia;
use src\models\OcorrenciaDAO;


class OcorrenciaDAOMySql implements OcorrenciaDAO
{

    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    private function generateOcorrencias($array)
    {

        $novaOcorrencia = new Ocorrencia();
        $novaOcorrencia->id = $array['id'] ?? 0;
        $novaOcorrencia->equipe = $array['equipe'] ?? '';
        $novaOcorrencia->forma_conhecimento = $array['forma_conhecimento'] ?? '';
        $novaOcorrencia->data_ocorrencia = $array['data_ocorrencia'] ?? '';
        $novaOcorrencia->hora_ocorrencia = $array['hora_ocorrencia'] ?? '';
        $novaOcorrencia->titulo = $array['titulo'] ?? '';
        $novaOcorrencia->area = $array['area'] ?? '';
        $novaOcorrencia->local = $array['local'] ?? '';
        $novaOcorrencia->tipo_natureza = $array['tipo_natureza'] ?? '';
        $novaOcorrencia->natureza = $array['natureza'] ?? '';
        $novaOcorrencia->descricao = $array['descricao'] ?? '';
        $novaOcorrencia->acoes = $array['acoes'] ?? '';
        $novaOcorrencia->usuario = $array['id_usuario'] ?? '';
        $novaOcorrencia->ativosLista = $array['id_ocorrencia'] ?? '';

        return $novaOcorrencia;
    }

    public function cadastrarNovaOcorrencia(Ocorrencia $novaOcorrencia)
    {
        if (!empty($novaOcorrencia)) {
            $sql = $this->pdo->prepare("INSERT INTO ocorrencias
                 (equipe,
                 forma_conhecimento, 
                 data_ocorrencia,
                 hora_ocorrencia, 
                 titulo, 
                 area, 
                 local, 
                 tipo_natureza, 
                 natureza, 
                 descricao, 
                 acoes, 
                 id_usuario ) 
                 VALUES (
                 :equipe, :forma_conhecimento, :data_ocorrencia, :hora_ocorrencia, :titulo,
                 :area,:local, :tipo_natureza, :natureza,:descricao,:acoes, :id_usuario)");

            $sql->bindValue(':equipe', $novaOcorrencia->equipe);
            $sql->bindValue(':forma_conhecimento', $novaOcorrencia->forma_conhecimento);
            $sql->bindValue(':data_ocorrencia', $novaOcorrencia->data_ocorrencia);
            $sql->bindValue(':hora_ocorrencia', $novaOcorrencia->hora_ocorrencia);
            $sql->bindValue(':titulo', $novaOcorrencia->titulo);
            $sql->bindValue(':area', $novaOcorrencia->area);
            $sql->bindValue(':local', $novaOcorrencia->local);
            $sql->bindValue(':tipo_natureza', $novaOcorrencia->tipo_natureza);
            $sql->bindValue(':natureza', $novaOcorrencia->natureza);
            $sql->bindValue(':descricao', $novaOcorrencia->descricao);
            $sql->bindValue(':acoes', $novaOcorrencia->acoes);
            $sql->bindValue(':id_usuario', $novaOcorrencia->usuario);

            $sql->execute();

            if ($sql->rowCount() > 0) {
                $ultimoId = $this->pdo->lastInsertId();
                return $ultimoId;
            }
        }
        return false;
    }

    public function atualizaOcorrenciaById(
        $id_ocorrencia,
        $equipe,
        $forma_conhecimento,
        $data_ocorrencia,
        $hora_ocorrencia,
        $titulo,
        $area,
        $local,
        $tipo_natureza,
        $natureza,
        $descricao,
        $acoes,
        $id_usuario
    ) {

        if (!empty($id_ocorrencia)) {
            $sql = $this->pdo->prepare("UPDATE ocorrencias 
                                        SET
                                        equipe=:equipe,
                                        forma_conhecimento=:forma_conhecimento,
                                        data_ocorrencia=:data_ocorrencia,
                                        hora_ocorrencia=:hora_ocorrencia,
                                        titulo=:titulo,
                                        area=:area,
                                        local=:local,
                                        tipo_natureza=:tipo_natureza,
                                        natureza=:natureza,
                                        descricao=:descricao,
                                        acoes=:acoes,
                                        id_usuario=:id_usuario
                                        WHERE
                                        id=$id_ocorrencia");

            $sql->bindValue(':equipe', $equipe);
            $sql->bindValue(':forma_conhecimento', $forma_conhecimento);
            $sql->bindValue(':data_ocorrencia', $data_ocorrencia);
            $sql->bindValue(':hora_ocorrencia', $hora_ocorrencia);
            $sql->bindValue(':titulo', $titulo);
            $sql->bindValue(':area', $area);
            $sql->bindValue(':local', $local);
            $sql->bindValue(':tipo_natureza', $tipo_natureza);
            $sql->bindValue(':natureza', $natureza);
            $sql->bindValue(':descricao', $descricao);
            $sql->bindValue(':acoes', $acoes);
            $sql->bindValue(':id_usuario', $id_usuario);
            $result = $sql->execute();
            if ($result) {
                // Verificar se alguma linha foi realmente atualizada
                if ($result > 0) {
                    return true;
                } else {
                    return false;
                }
            } else {
                echo "Erro ao executar a atualização.";
                return false;
            }
        }
    }

    public function listarTodasOcorrencias()
    {
        $listaOcorrencias = [];
        $porPagina = 20;
        $paginaSolicitada = intval(filter_input(INPUT_GET, "p"));

        if ($paginaSolicitada < 1) {
            $paginaSolicitada = 1;
        }

        $offset = ($paginaSolicitada - 1) * $porPagina;

        $sql = $this->pdo->query("SELECT COUNT(*) AS c FROM ocorrencias");
        $totalDeLinhas = $sql->fetch();
        $totalDeOcorrencias =   $totalDeLinhas['c'];

        $contagemPaginas = ceil($totalDeOcorrencias / $porPagina);
        $paginaInicial = (ceil($paginaSolicitada / $porPagina) * -1) * $porPagina + 1;
        $paginaFinal = min($paginaSolicitada + $porPagina - 1, $contagemPaginas);

        $sql = $this->pdo->prepare("SELECT * FROM ocorrencias
                         ORDER BY data_ocorrencia DESC, 
                         hora_ocorrencia DESC
                         LIMIT $offset, $porPagina");
        $sql->execute();



        if ($sql->rowCount() > 0) {
            $ocorrenciaListaArray = $sql->fetchAll(PDO::FETCH_ASSOC);
            $ocorrenciasLista = array_filter($ocorrenciaListaArray, function ($item) {
                return !empty($item);
            });

            foreach ($ocorrenciasLista as $ocorrenciaItem) {
                $novaOcorrencia = $this->generateOcorrencias($ocorrenciaItem);

                $sql = $this->pdo->prepare("SELECT * FROM usuarios WHERE id=:id_usuario");
                $sql->bindValue(':id_usuario', $novaOcorrencia->usuario);
                $sql->execute();

                if ($sql->rowCount() > 0) {
                    $data = $sql->fetch(PDO::FETCH_ASSOC);
                    $usuarioDAO = new UserDAOMySql($this->pdo);
                    $novaOcorrencia->usuario = $usuarioDAO->generateUser($data);
                }

                $sql = $this->pdo->prepare("SELECT * FROM ativos WHERE id_ocorrencia=:id_ocorrencia");
                $sql->bindValue(':id_ocorrencia', $novaOcorrencia->id);
                $sql->execute();

                if ($sql->rowCount() > 0) {
                    $dataAtivos = $sql->fetchAll(PDO::FETCH_ASSOC);
                    $novaOcorrencia->ativosLista = $dataAtivos;
                }

                $sql = $this->pdo->prepare("SELECT * FROM envolvidos WHERE id_ocorrencia=:id_ocorrencia");
                $sql->bindValue(':id_ocorrencia', $novaOcorrencia->id);
                $sql->execute();

                if ($sql->rowCount() > 0) {
                    $dataEnvolvidos = $sql->fetchAll(PDO::FETCH_ASSOC);
                    $novaOcorrencia->envolvidosLista = $dataEnvolvidos;
                }

                $sql = $this->pdo->prepare("SELECT * FROM fotos WHERE id_ocorrencia=:id_ocorrencia");
                $sql->bindValue(':id_ocorrencia', $novaOcorrencia->id);
                $sql->execute();

                if ($sql->rowCount() > 0) {
                    $data = $sql->fetchAll(PDO::FETCH_ASSOC);
                    $novaOcorrencia->fotosOcorrencias = $data;
                }

                $listaOcorrencias[] = $novaOcorrencia;
            }


            return [
                'ocorrencias' => $listaOcorrencias,
                'porPagina' => $contagemPaginas,
                'paginaAtual' => $paginaSolicitada,
                'paginaInicial' => $paginaInicial,
                'paginaFinal' => $paginaFinal,
                'totalDePaginas' => $contagemPaginas

            ];
        }
        return false;
    }


    public function getOcorrenciaById()
    {

        $ocorrencia_id = intval(filter_input(INPUT_GET, "ocorrencia_id"));

        if ($ocorrencia_id) {
            $sql = $this->pdo->query("SELECT * FROM ocorrencias WHERE id=$ocorrencia_id");
            if ($sql->rowCount() > 0) {
                $ocorrenciaArray = $sql->fetch(PDO::FETCH_ASSOC);
                $ocorrenciaEncontrada = $this->generateOcorrencias($ocorrenciaArray);

                $sql = $this->pdo->query("SELECT * FROM usuarios WHERE id= $ocorrenciaEncontrada->usuario");
                if ($sql->rowCount() > 0) {
                    $usuarioArray = $sql->fetch(PDO::FETCH_ASSOC);
                    $usuarioDAO = new UserDAOMySql($this->pdo);
                    $ocorrenciaEncontrada->usuario =  $usuarioDAO->generateUser($usuarioArray);
                }

                $sql = $this->pdo->query("SELECT * FROM ativos WHERE id_ocorrencia= $ocorrenciaEncontrada->id");

                if ($sql->rowCount() > 0) {
                    $dataAtivos = $sql->fetchAll(PDO::FETCH_ASSOC);

                    $ocorrenciaEncontrada->ativosLista = [];
                    foreach ($dataAtivos as $item) {
                        $ativoDAO = new AtivoDAOMySql($this->pdo);
                        $ativoEncontrado = $ativoDAO->arrayAtivoParaObjetoAtivo($item);
                        array_push($ocorrenciaEncontrada->ativosLista, $ativoEncontrado);
                    }
                }

                $sql = $this->pdo->query("SELECT * FROM envolvidos WHERE id_ocorrencia= $ocorrenciaEncontrada->id");
                if ($sql->rowCount() > 0) {
                    $dataEnvolvidos = $sql->fetchAll(PDO::FETCH_ASSOC);

                    $ocorrenciaEncontrada->envolvidosLista = [];
                    foreach ($dataEnvolvidos as $item) {
                        $envolvidosDAO = new EnvolvidoDAOMySql($this->pdo);
                        $envolvidosEncontrado = $envolvidosDAO->arrayEnvolvidoParaObjetoEnvolvido($item);
                        array_push($ocorrenciaEncontrada->envolvidosLista, $envolvidosEncontrado);
                    }
                }


                $sql = $this->pdo->query("SELECT * FROM fotos WHERE id_ocorrencia= $ocorrenciaEncontrada->id");
                if ($sql->rowCount() > 0) {
                    $dataFoto = $sql->fetchAll(PDO::FETCH_ASSOC);
                    $ocorrenciaEncontrada->fotosOcorrencias = [];
                    foreach ($dataFoto as $item) {
                        $fotoDAO = new FotoDAOMySql($this->pdo);
                        $fotoEncontrada = $fotoDAO->arrayFotoParaObjetoFoto($item);
                        array_push($ocorrenciaEncontrada->fotosOcorrencias, $fotoEncontrada);
                    }
                }

                return $ocorrenciaEncontrada;

                // echo '<pre>';
                // print_r($ocorrenciaEncontrada);
                // exit;
            }
        }
        return false;
    }

    public function excluirOcorrencia($id)
    {
        $ocorrenciaDeletada = "";
        if ($id) {

            $sql = $this->pdo->prepare("DELETE FROM ocorrencias WHERE id = :id ;");
            $sql->bindValue(':id', $id);

            if ($sql->execute()) {
                $ocorrenciaDeletada =  $sql->rowCount();
            } else {
                return false;
            }
        }
        if ($ocorrenciaDeletada > 0) {
            $ativoDAO = new AtivoDAOMySql($this->pdo);
            $ativoDAO->excluirAtivosByOcorrencia($id);
        }

        if ($ocorrenciaDeletada > 0) {
            $envolvidosDAO = new EnvolvidoDAOMySql($this->pdo);
            $envolvidosDAO->excluirEnvolvidosByOcorrencia($id);
        }

        if ($ocorrenciaDeletada > 0) {
            $fotosDAO = new FotoDAOMySql($this->pdo);
            $fotosDAO->excluirFotosByOcorrencia($id);
        }
    }

    public function getOcorrenciaByDates($data_inicio, $data_fim)
    {
        $listaOcorrencias = [];
        $porPagina = 20;
        $paginaSolicitada = intval(filter_input(INPUT_GET, "p"));

        if ($paginaSolicitada < 1) {
            $paginaSolicitada = 1;
        }

        $offset = ($paginaSolicitada - 1) * $porPagina;

        $sql = $this->pdo->query("SELECT COUNT(*) AS c FROM ocorrencias");
        $totalDeLinhas = $sql->fetch();
        $totalDeOcorrencias =   $totalDeLinhas['c'];

        $contagemPaginas = ceil($totalDeOcorrencias / $porPagina);
        $paginaInicial = (ceil($paginaSolicitada / $porPagina) * -1) * $porPagina + 1;
        $paginaFinal = min($paginaSolicitada + $porPagina - 1, $contagemPaginas);

        $sql = $this->pdo->query("SELECT * FROM ocorrencias
                         WHERE data_ocorrencia >= '$data_inicio' AND data_ocorrencia <= '$data_fim'
                         ORDER BY data_ocorrencia DESC, 
                         hora_ocorrencia DESC
                         LIMIT $offset, $porPagina");


        if ($sql->rowCount() > 0) {
            $ocorrenciaListaArray = $sql->fetchAll(PDO::FETCH_ASSOC);
            $ocorrenciasLista = array_filter($ocorrenciaListaArray, function ($item) {
                return !empty($item);
            });

            foreach ($ocorrenciasLista as $ocorrenciaItem) {
                $novaOcorrencia = $this->generateOcorrencias($ocorrenciaItem);

                $sql = $this->pdo->prepare("SELECT * FROM usuarios WHERE id=:id_usuario");
                $sql->bindValue(':id_usuario', $novaOcorrencia->usuario);
                $sql->execute();

                if ($sql->rowCount() > 0) {
                    $data = $sql->fetch(PDO::FETCH_ASSOC);
                    $usuarioDAO = new UserDAOMySql($this->pdo);
                    $novaOcorrencia->usuario = $usuarioDAO->generateUser($data);
                }

                $sql = $this->pdo->prepare("SELECT * FROM ativos WHERE id_ocorrencia=:id_ocorrencia");
                $sql->bindValue(':id_ocorrencia', $novaOcorrencia->id);
                $sql->execute();

                if ($sql->rowCount() > 0) {
                    $dataAtivos = $sql->fetchAll(PDO::FETCH_ASSOC);
                    $novaOcorrencia->ativosLista = $dataAtivos;
                }

                $sql = $this->pdo->prepare("SELECT * FROM envolvidos WHERE id_ocorrencia=:id_ocorrencia");
                $sql->bindValue(':id_ocorrencia', $novaOcorrencia->id);
                $sql->execute();

                if ($sql->rowCount() > 0) {
                    $dataEnvolvidos = $sql->fetchAll(PDO::FETCH_ASSOC);
                    $novaOcorrencia->envolvidosLista = $dataEnvolvidos;
                }

                $sql = $this->pdo->prepare("SELECT * FROM fotos WHERE id_ocorrencia=:id_ocorrencia");
                $sql->bindValue(':id_ocorrencia', $novaOcorrencia->id);
                $sql->execute();

                if ($sql->rowCount() > 0) {
                    $data = $sql->fetchAll(PDO::FETCH_ASSOC);
                    $novaOcorrencia->fotosOcorrencias = $data;
                }

                $listaOcorrencias[] = $novaOcorrencia;
            }


            return [
                'ocorrencias' => $listaOcorrencias,
                'porPagina' => $contagemPaginas,
                'paginaAtual' => $paginaSolicitada,
                'paginaInicial' => $paginaInicial,
                'paginaFinal' => $paginaFinal,
                'totalDePaginas' => $contagemPaginas

            ];
        }
        return false;
    }
}
