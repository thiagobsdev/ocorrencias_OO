<?php

namespace src\handlers;


use \src\models\Foto;


class FotosHandler
{

    public static function addFotos($arquivos, $data_ocorrencia, $id_ocorrencia, $id_usuario)
    {

        for ($count = 0; $count < count($arquivos['name']); $count++) {
            $diretorioPelaData = "fotos_ocorrencias/$data_ocorrencia/";
            mkdir($diretorioPelaData, 0755);
           

            $destino  = $diretorioPelaData . $arquivos['name'][$count];
            if (move_uploaded_file($arquivos['tmp_name'][$count], $destino)) {

                Foto::insert([
                    'nome'=> $arquivos['name'][$count],
                    'url' => $destino,
                    'id_ocorrencia'=>$id_ocorrencia,
                    'id_usuario'=>$id_usuario
                ])->execute();
            } 
        }
    }

    public static function excluirFoto($id) {
        Foto::delete()->where('id', $id)->execute();
    }

    
}
