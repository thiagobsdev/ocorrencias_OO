<?php

namespace src\handlers;

use PDO;

use \src\models\Envolvido;
use src\models\OcorrenciaEnvolvido;

class EnvolvidoHandler
{

    public static function addEnvolvidos($id_ocorrencia, $envolvidos)
    {
        $envolvidosAdicionadoslista = [];

        foreach ($envolvidos as $envolvido) {
            $envolvidoInserido = Envolvido::insert([
                'id_ocorrencia' => $id_ocorrencia,
                'nome' => $envolvido['nome'],
                'tipo_de_documento' => $envolvido['tipo_documento'],
                'numero_documento' => $envolvido['numero_documento'],
                'envolvimento' => $envolvido['envolvimento'],
                'vinculo' => $envolvido['vinculo'],
                'tipo_veiculo' => $envolvido['tipo_veiculo'],
                'placa' => $envolvido['placa'],
            ])->execute();


            $envolvidosAdicionadoslista[] = $envolvidoInserido;

            OcorrenciaEnvolvido::insert([
                'id_ocorrencia' => $id_ocorrencia,
                'id_envolvido' => $envolvidoInserido
            ])->execute();
        }

        return $envolvidosAdicionadoslista;
    }

    public static function atualizarEnvolvidosEdit($id_ocorrencia, $envolvidos)
    {

        if (!empty($envolvidos)) {
            foreach ($envolvidos as $envolvido) {
                if (!isset($envolvido['id'])) {
                    Envolvido::insert(
                        [
                            'id_ocorrencia' => $id_ocorrencia,
                            'nome' => $envolvido['nome'],
                            'tipo_de_documento' => $envolvido['tipo_documento'],
                            'numero_documento' => $envolvido['numero_documento'],
                            'envolvimento' => $envolvido['envolvimento'],
                            'vinculo' => $envolvido['vinculo'],
                            'tipo_veiculo' => $envolvido['tipo_veiculo'],
                            'placa' => $envolvido['placa'],
                        ]
                    )->execute();
                }
            }
        }
    }

    public static function excluirEnvolvido($id)
    {
        Envolvido::delete()->where('id', $id)->execute();
    }

    public static function getBYDocumentoEnvolvimentoOuNome(
        $nomeEnvolvido,
        $numeroDocumentoEnvolvido,
        $envolvimentoEnvolvido,
    ) {
        $envolvidosEncontrados = Envolvido::select()
            ->where('numero_documento', $numeroDocumentoEnvolvido)
            ->where('envolvimento', $envolvimentoEnvolvido)
            ->orWhere('nome', 'like', $nomeEnvolvido . '%')
            ->get();
        return ($envolvidosEncontrados) ? $envolvidosEncontrados : false;
    }
}
