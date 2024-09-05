<?php

require_once 'models/Ocorrencia.php';

use src\models\Ocorrencia;
use src\models\OcorrenciaDAO;


class OcorrenciaDAOMySql implements OcorrenciaDAO
{

    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    private function generateOcorrencia($array)
    {

        $novaOcorrencia = new Ocorrencia();
        $novaOcorrencia->id = $array['id'] ?? 0;
        $novaOcorrencia->equipe = $array['equipe'] ?? "";
        $novaOcorrencia->forma_conhecimento = $array['forma_conhecimento'] ?? "";
        $novaOcorrencia->data_ocorrencia = $array['data_ocorrencia'] ?? "";
        $novaOcorrencia->hora_ocorrencia = $array['hora_ocorrencia'] ?? "";
        $novaOcorrencia->titulo = $array['titulo'] ?? "";
        $novaOcorrencia->area = $array['area'] ?? "";
        $novaOcorrencia->local = $array['local'] ?? "";
        $novaOcorrencia->tipo_natureza = $array['tipo_natureza'] ?? "";
        $novaOcorrencia->descricao = $array['descricao'] ?? "";
        $novaOcorrencia->acoes = $array['acoes'] ?? "";
        $novaOcorrencia->id_usuario = $array['id_usuario'] ?? 0;

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
            $sql->bindValue(':id_usuario', $novaOcorrencia->id_usuario);

            $sql->execute();

            if ($sql->rowCount() > 0) {
                $ultimoId = $this->pdo->lastInsertId();
                return $ultimoId;
            }
        }
        return false;
    }
}
