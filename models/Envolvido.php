<?php
namespace src\models;


class Envolvido  {

    public $id;
    public $nome;
    public $tipo_de_documento;
    public $numero_documento;
    public $envolvimento;
    public $vinculo;
    public $tipo_veiculo;
    public $placa;
    public $id_ocorrencia;

}
interface envolvidoDAO
{
     public function cadastrarEnvolvidos($envolvidos, $id_ocorrencia);

}

