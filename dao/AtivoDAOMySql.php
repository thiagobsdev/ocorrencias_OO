<?php

require_once 'models/Ativo.php';

use src\models\Ativo;
use src\models\ativoDAO;



class AtivoDAOMySql implements ativoDAO
{

    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function arrayAtivoParaObjetoAtivo($array)
    {

        $novoAtivo = new Ativo();
        $novoAtivo->id = $array['id'] ?? 0;
        $novoAtivo->tipo_ativo = $array['tipo_ativo'] ?? "";
        $novoAtivo->id_ativo = $array['id_ativo'] ?? "";
        $novoAtivo->id_ocorrencia = $array['id_ocorrencia'] ?? "";
        return $novoAtivo;
    }

    public function cadastrarAtivos($ativos, $id_ocorrencia)
    {

        if (!empty($ativos)) {
            foreach ($ativos as $ativo) {
                $sql = $this->pdo->prepare("INSERT INTO ativos
                 (tipo_ativo,
                 id_ativo, 
                 id_ocorrencia) 
                 VALUES (:tipo_ativo, 
                 :id_ativo, 
                 :id_ocorrencia)");
                $sql->bindValue(':tipo_ativo', $ativo['tipoAtivo']);
                $sql->bindValue(':id_ativo', $ativo['idAtivo']);
                $sql->bindValue(':id_ocorrencia', $id_ocorrencia);

                $sql->execute();
            }

            return true;
        }
        return false;
    }

    public function excluirAtivosByOcorrencia($id_ocorrencia)
    {
        if (isset($id_ocorrencia) && $id_ocorrencia > 0) {
            $sql = $this->pdo->prepare("DELETE FROM ativos WHERE id_ocorrencia = :id_ocorrencia ;");
            $sql->bindValue(':id_ocorrencia', $id_ocorrencia);

            if ($sql->execute()) {
                return $sql->rowCount();
            } else {
                return false;
            }
        }
    }
}
