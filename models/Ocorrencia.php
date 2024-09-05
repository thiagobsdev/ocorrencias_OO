<?php
namespace src\models;


class Ocorrencia  {

     public $id;
     public $equipe;

     public $forma_conhecimento;
     public $data_ocorrencia;
     public $hora_ocorrencia;
     public $titulo;
     public $area;
     public $local;
     public $tipo_natureza;
     public $natureza;
     public $descricao;
     public $acoes;
     public $id_usuario;
     public $envolvidosLista;
     public $ativosLista;
     public $fotosOcorrencias;
     public $comentarios;

}

interface OcorrenciaDAO
{
     public function cadastrarNovaOcorrencia(Ocorrencia $novaOcorrencia);

}