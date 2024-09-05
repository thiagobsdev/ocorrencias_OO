<?php

namespace src\handlers;


use \src\models\Ativo;


class AtivosHandler
{

    public static function addAtivos($id_ocorrencia, $ativos)
    {

        foreach ($ativos as $ativo) {
            Ativo::insert([
                'id_ocorrencia' => $id_ocorrencia,
                'tipo_ativo' => $ativo['tipoAtivo'],
                'id_ativo' => $ativo['idAtivo'],

            ])->execute();
        }
    }

    public static function atualizarEnvolvidosEdit($id_ocorrencia, $ativosLista)
    {

        if (!empty($ativosLista)) {
            foreach ($ativosLista as $ativo) {

                if (!isset($ativo['id'])) {
                    Ativo::insert(
                        [
                            'id_ocorrencia' => $id_ocorrencia,
                            'tipo_ativo' => $ativo['tipoAtivo'],
                            'id_ativo' => $ativo['idAtivo'],
                        ]
                    )->execute();
                }
            }
        }
    }

    public static function excluirAtivo($id) {
        Ativo::delete()->where('id', $id)->execute();
    }
}
