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
     public $usuario;
     public $envolvidosLista;
     public $ativosLista;
     public $fotosOcorrencias;
     public $listaComentarios;

}

interface OcorrenciaDAO
{
     public function cadastrarNovaOcorrencia(Ocorrencia $novaOcorrencia);
     public function listarTodasOcorrencias();

}