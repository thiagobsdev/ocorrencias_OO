<?php

require_once 'models/Ocorrencia.php';
require_once 'dao/UserDAOMySql.php';


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

    public function listarTodasOcorrencias()
    {
        $listaOcorrencias = [];

        $sql = $this->pdo->prepare("SELECT * FROM ocorrencias ORDER BY data_ocorrencia DESC, hora_ocorrencia DESC;");
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
            return $listaOcorrencias;
        }
        return false;
    }
}
