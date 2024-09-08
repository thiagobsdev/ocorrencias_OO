<?php

require_once 'models/Foto.php';

use src\models\Foto;
use src\models\FotoDAO;

class FotoDAOMySql implements FotoDAO
{

    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function arrayFotoParaObjetoFoto($array)
    {

        $novaFoto = new Foto();
        $novaFoto->id = $array['id'] ?? 0;
        $novaFoto->nome = $array['nome'] ?? "";
        $novaFoto->url = $array['url'] ?? "";
        $novaFoto->id_ocorrencia = $array['id_ocorrencia'] ?? "";
        $novaFoto->id_usuario = $array['id_usuario'] ?? "";
        return $novaFoto;
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



    public function excluirFotosByOcorrencia($id_ocorrencia)
    {
        if (isset($id_ocorrencia) && $id_ocorrencia > 0) {
            $sql = $this->pdo->prepare("DELETE FROM fotos WHERE id_ocorrencia = :id_ocorrencia ;");
            $sql->bindValue(':id_ocorrencia', $id_ocorrencia);

            if ($sql->execute()) {
                return $sql->rowCount();
            } else {
                return false;
            }
        }
    }

    public function excluirFotoById($id)
    {
        if ($id) {

            $sql = $this->pdo->prepare("DELETE FROM fotos WHERE id = :id;");
            $sql->bindValue(':id', $id);
            $sql->execute();
        }
    }
}
