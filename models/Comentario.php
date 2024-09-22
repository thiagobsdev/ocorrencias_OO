<?php

namespace src\models;


class Comentario
{

    public $id;
    public $texto;
    public $id_ocorrencia;
    public $usuario;
}
interface comentarioDAO
{
     public function cadastrarComentario($texto, $id_ocorrencia, $usuario);
     public function listarComentariosByIdOcorrencia($id_ocorrencia);

}