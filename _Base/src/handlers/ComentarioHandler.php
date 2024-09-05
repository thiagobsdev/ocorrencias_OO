<?php

namespace src\handlers;


use \src\models\Comentario;


class ComentarioHandler
{

    public static function salvarComentario( $texto, $id_ocorrencia, $id_usuario) {

        $insertQuery = Comentario::insert([
            'texto' => $texto,
            'id_ocorrencia' => $id_ocorrencia,
            'id_usuario' => $id_usuario,
            
        ])->execute();

        return $insertQuery;
    }


  
}