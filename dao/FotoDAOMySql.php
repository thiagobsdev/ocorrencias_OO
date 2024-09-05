<?php

require_once 'models/Foto.php';

use src\models\FotoDAO;

class FotoDAOMySql implements FotoDAO
{

    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function salvarFotos($arquivos, $data_ocorrencia, $id_ocorrencia, $id_usuario)
    {
        for ($count = 0; $count < count($arquivos['name']); $count++) {
            $diretorioPelaData = "fotos_ocorrencias/$data_ocorrencia/";
            mkdir($diretorioPelaData, 0755, true);


            $destino  = $diretorioPelaData . $arquivos['name'][$count];
            if (move_uploaded_file($arquivos['tmp_name'][$count], $destino)) {

                $sql = $this->pdo->prepare("INSERT INTO fotos
                 (nome,
                 url, 
                 id_ocorrencia,
                 id_usuario) 
                 VALUES (:nome, 
                 :url, 
                 :id_ocorrencia,
                 :id_usuario)");
                $sql->bindValue(':nome', $arquivos['name'][$count]);
                $sql->bindValue(':url', $destino);
                $sql->bindValue(':id_ocorrencia', $id_ocorrencia);
                $sql->bindValue(':id_usuario', $id_usuario);

                $sql->execute();
            }
        }
    }
}
