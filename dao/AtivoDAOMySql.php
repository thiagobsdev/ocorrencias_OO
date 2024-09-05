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
}
