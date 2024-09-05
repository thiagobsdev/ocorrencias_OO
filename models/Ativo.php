<?php
namespace src\models;


class Ativo  {

    public $id;
    public $tipo_ativo;
    public $id_ativo;
    public $id_ocorrencia;

}

interface ativoDAO
{
     public function cadastrarAtivos($ativos, $id_ocorrencia);

}