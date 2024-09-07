<?php

require_once 'models/Envolvido.php';

use src\models\envolvidoDAO;
use src\models\Envolvido;



class EnvolvidoDAOMySql implements envolvidoDAO
{

    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function cadastrarEnvolvidos($envolvidos, $id_ocorrencia)
    {

        if (!empty($envolvidos)) {
            foreach ($envolvidos as $envolvido) {
                $sql = $this->pdo->prepare("INSERT INTO envolvidos
                 (nome,
                 tipo_de_documento, 
                 numero_documento, 
                 envolvimento,
                 vinculo,
                 tipo_veiculo,
                 placa, 
                 id_ocorrencia) 
                 VALUES (:nome, 
                 :tipo_de_documento, 
                 :numero_documento, 
                 :envolvimento, 
                 :vinculo,
                 :tipo_veiculo,
                 :placa,
                 :id_ocorrencia)");
                $sql->bindValue(':nome', $envolvido['nome']);
                $sql->bindValue(':tipo_de_documento', $envolvido['tipo_documento']);
                $sql->bindValue(':numero_documento', $envolvido['numero_documento']);
                $sql->bindValue(':envolvimento', $envolvido['envolvimento']);
                $sql->bindValue(':vinculo', $envolvido['vinculo']);
                $sql->bindValue(':tipo_veiculo', $envolvido['tipo_veiculo']);
                $sql->bindValue(':placa', $envolvido['placa']);
                $sql->bindValue(':id_ocorrencia', $id_ocorrencia);

                $sql->execute();
            }

            return true;
        }
        return false;
    }

    public function excluirEnvolvidosByOcorrencia($id_ocorrencia)
    {

        if (isset($id_ocorrencia) && $id_ocorrencia > 0) {
            $sql = $this->pdo->prepare("DELETE FROM envolvidos WHERE id_ocorrencia = :id_ocorrencia ;");
            $sql->bindValue(':id_ocorrencia', $id_ocorrencia);

            if ($sql->execute()) {
                return $sql->rowCount();
            } else {
                return false;
            }
        }
    }
}
