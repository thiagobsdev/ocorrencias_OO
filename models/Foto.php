<?php
namespace src\models;


class Foto  {

    public $id;
    public $nome;
    public $url;
    public $id_ocorrencia;
    public $id_usuario;

}

interface FotoDAO {
    public function salvarFotos($arquivos, $data_ocorrencia, $id_ocorrencia, $id_usuario);
}