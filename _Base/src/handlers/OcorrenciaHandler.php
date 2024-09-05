<?php

namespace src\handlers;

use \src\models\Ocorrencia;
use src\models\Usuario;
use \src\models\Envolvido;
use \src\models\Ativo;
use \src\models\Foto;

class OcorrenciaHandler
{



    public static function addOcorrencia(
        $equipe,
        $forma_conhecimento,
        $data_ocorrencia,
        $hora_ocorrencia,
        $titulo,
        $area,
        $local,
        $tipo_natureza,
        $natureza,
        $descricao,
        $acoes,
        $id_usuario,

    ) {
        $insertQuery = Ocorrencia::insert([
            'equipe' => $equipe,
            'forma_conhecimento' => $forma_conhecimento,
            'data_ocorrencia' => $data_ocorrencia,
            'hora_ocorrencia' => $hora_ocorrencia,
            'titulo' => $titulo,
            'area' => $area,
            'local' => $local,
            'tipo_natureza' => $tipo_natureza,
            'natureza' => $natureza,
            'descricao' => $descricao,
            'acoes' => $acoes,
            'id_usuario' => $id_usuario,
        ])->execute();

        return $insertQuery;
    }

    public static function getAllOcorrencias($page)
    {
        $porPagina = 30;
        $ocorrenciasLista = Ocorrencia::select()
            ->orderBy('data_ocorrencia', 'desc')
            ->orderBy('hora_ocorrencia', 'desc')
            ->page($page, $porPagina)
            ->get();

        $totalDeOcorrencias = Ocorrencia::select()->count();
        $contagemPaginas = ceil($totalDeOcorrencias / $porPagina);
        $paginaInicial = (ceil($page / $porPagina) * -1) * $porPagina + 1;
        $paginaFinal = min($page + $porPagina - 1, $contagemPaginas);

        $ocorrencias = [];
        foreach ($ocorrenciasLista as $ocorrenciaItem) {
            if ($ocorrenciaItem) {
                $novaOcorrencia = OcorrenciaHandler::arrayOcorrenciaParaObjetoOcorrencia($ocorrenciaItem);
            }

            $novoUsuario = Usuario::select()->where('id', $ocorrenciaItem['id_usuario'])->one();

            if ($novoUsuario) {
                $novaOcorrencia->usuario = OcorrenciaHandler::arrayUsuarioParaObjetoUsuario($novoUsuario);
            }

            $envolvidosLista = Envolvido::select()->where('id_ocorrencia', $ocorrenciaItem['id'])->get();
            if (count($envolvidosLista) > 0) {
                $novaOcorrencia->envolvidosLista = [];
                foreach ($envolvidosLista as $envolvido) {
                    $novaOcorrencia->envolvidosLista[] = OcorrenciaHandler::arrayEnvolvidoparaObjetoEnvolvido($envolvido);
                }
            }

            $ativosLista = Ativo::select()->where('id_ocorrencia', $ocorrenciaItem['id'])->get();
            if (count($ativosLista) > 0) {
                $novaOcorrencia->ativosLista = [];
                foreach ($ativosLista as $ativo) {
                    $novaOcorrencia->ativosLista[] = OcorrenciaHandler::arrayAtivoParaObjetoAtivo($ativo);
                }
            }

            $fotosLista = Foto::select()->where('id_ocorrencia', $ocorrenciaItem['id'])->get();
            if (count($fotosLista) > 0) {
                $novaOcorrencia->fotosOcorrencias = [];
                foreach ($fotosLista as $foto) {
                    $novaOcorrencia->fotosOcorrencias[] = OcorrenciaHandler::arrayFotosparaObjetoFotos($foto);
                }
            }

            $ocorrencias[] = $novaOcorrencia;
        }
        return [
            'ocorrencias' => $ocorrencias,
            'porPagina' => $contagemPaginas,
            'paginaAtual' => $page,
            'paginaInicial' => $paginaInicial,
            'paginaFinal' => $paginaFinal,
            'totalDePaginas' => $contagemPaginas

        ];
    }

    public static function getOcorrenciaById(
        $id_ocorrencia,
        $dataInicio = '1990-01-01',
        $dataFim = '2100-12-31'
    ) {

        $ocorrencia = Ocorrencia::select()
            ->where('id', $id_ocorrencia)
            ->where('data_ocorrencia', '>=', $dataInicio)
            ->where('data_ocorrencia', '<=', $dataFim)
            ->orderBy('data_ocorrencia', 'desc')
            ->orderBy('hora_ocorrencia', 'desc')
            ->one();

        if (!empty($ocorrencia)) {
            $novaOcorrencia = OcorrenciaHandler::arrayOcorrenciaParaObjetoOcorrencia($ocorrencia);

            $novoUsuario = Usuario::select()->where('id', $ocorrencia['id_usuario'])->orderBy('id', 'desc')->one();
            if (!empty($novoUsuario)) {
                $novaOcorrencia->usuario = OcorrenciaHandler::arrayUsuarioParaObjetoUsuario($novoUsuario);
            }

            $envolvidosLista = Envolvido::select()->where('id_ocorrencia', $ocorrencia['id'])->get();
        
            if (!empty($envolvidosLista) && count($envolvidosLista) > 0) {
                $novaOcorrencia->envolvidosLista = [];
                foreach ($envolvidosLista as $envolvido) {
                    $novaOcorrencia->envolvidosLista[] = OcorrenciaHandler::arrayEnvolvidoparaObjetoEnvolvido($envolvido);
                }
            }

            $ativosLista = Ativo::select()->where('id_ocorrencia', $ocorrencia['id'])->get();
            if ( !empty($ativosLista) && count($ativosLista) > 0) {
                $novaOcorrencia->ativosLista = [];
                foreach ($ativosLista as $ativo) {
                    $novaOcorrencia->ativosLista[]  = OcorrenciaHandler::arrayAtivoParaObjetoAtivo($ativo);
                }
            }

            $fotosLista = Foto::select()->where('id_ocorrencia', $ocorrencia['id'])->get();
            if ( !empty($fotosLista) && count($fotosLista) > 0) {
                $novaOcorrencia->fotosOcorrencias = [];
                foreach ($fotosLista as $foto) {
                    $novaOcorrencia->fotosOcorrencias[] = OcorrenciaHandler::arrayFotosparaObjetoFotos($foto);
                }
            }
            return ($novaOcorrencia) ? $novaOcorrencia : false;;
        }
    }

    public static function getOcorrenciaByEnvolvido($id_ocorrencia_envolvido)
    {

        $ocorrenciasLista = Ocorrencia::select()->where('id', $id_ocorrencia_envolvido)->get();

        $ocorrencias = [];
        foreach ($ocorrenciasLista as $ocorrenciaItem) {
            $novaOcorrencia = OcorrenciaHandler::arrayOcorrenciaParaObjetoOcorrencia($ocorrenciaItem);

            $novoUsuario = Usuario::select()->where('id', $ocorrenciaItem['id_usuario'])->one();
            if (!empty($novoUsuario)) {
                $novaOcorrencia->usuario = OcorrenciaHandler::arrayUsuarioParaObjetoUsuario($novoUsuario);
            }

            $envolvidosLista = Envolvido::select()->where('id_ocorrencia', $ocorrenciaItem['id'])->get();
            if ( !empty($envolvidosLista) && count($envolvidosLista) > 0) {
                $novaOcorrencia->envolvidosLista = [];
                foreach ($envolvidosLista as $envolvido) {
                    $novaOcorrencia->envolvidosLista[] = OcorrenciaHandler::arrayEnvolvidoparaObjetoEnvolvido($envolvido);
                }
            }

            $ativosLista = Ativo::select()->where('id_ocorrencia', $ocorrenciaItem['id'])->get();
            if ( !empty($ativosLista) && count($ativosLista) > 0) {
                $novaOcorrencia->ativosLista = [];
                foreach ($ativosLista as $ativo) {
                    $novaOcorrencia->ativosLista[] = OcorrenciaHandler::arrayAtivoParaObjetoAtivo($ativo);
                }
            }

            $fotosLista = Foto::select()->where('id_ocorrencia', $ocorrenciaItem['id'])->get();
            if (count($fotosLista) > 0) {
                $novaOcorrencia->fotosOcorrencias = [];
                foreach ($fotosLista as $foto) {
                    $novaOcorrencia->fotosOcorrencias[] = OcorrenciaHandler::arrayFotosparaObjetoFotos($foto);
                }
            }

            $ocorrencias[] = $novaOcorrencia;
        }
        return ['ocorrencias' => $ocorrencias];
    }

    public static function getOcorrenciaByIdEDatas($dataInicio,  $dataFim)
    {

        $ocorrenciasLista = Ocorrencia::select()
            ->where('data_ocorrencia', '>=', $dataInicio)
            ->where('data_ocorrencia', '<=', $dataFim)
            ->orderBy('data_ocorrencia', 'desc')
            ->orderBy('hora_ocorrencia', 'desc')
            ->get();

        $ocorrencias = [];

        foreach ($ocorrenciasLista as $ocorrenciaItem) {
            $novaOcorrencia = OcorrenciaHandler::arrayOcorrenciaParaObjetoOcorrencia($ocorrenciaItem);

            $novoUsuario = Usuario::select()->where('id', $ocorrenciaItem['id_usuario'])->one();
            $novaOcorrencia->usuario = OcorrenciaHandler::arrayUsuarioParaObjetoUsuario($novoUsuario);

            $envolvidosLista = Envolvido::select()->where('id_ocorrencia', $ocorrenciaItem['id'])->get();
            if ( !empty($envolvidosLista) && count($envolvidosLista) > 0) {
                $novaOcorrencia->envolvidosLista = [];
                foreach ($envolvidosLista as $envolvido) {
                    $novaOcorrencia->envolvidosLista[] = OcorrenciaHandler::arrayEnvolvidoparaObjetoEnvolvido($envolvido);
                }
            }

            $ativosLista = Ativo::select()->where('id_ocorrencia', $ocorrenciaItem['id'])->get();
            if ( !empty($ativosLista) && count($ativosLista) > 0) {
                $novaOcorrencia->ativosLista = [];
                foreach ($ativosLista as $ativo) {
                    $novaOcorrencia->ativosLista[] = OcorrenciaHandler::arrayAtivoParaObjetoAtivo($ativo);
                }
            }

            $fotosLista = Foto::select()->where('id_ocorrencia', $ocorrenciaItem['id'])->get();
            if ( !empty($fotosLista) && count($fotosLista) > 0) {
                $novaOcorrencia->fotosOcorrencias = [];
                foreach ($fotosLista as $foto) {
                    $novaOcorrencia->fotosOcorrencias[] = OcorrenciaHandler::arrayFotosparaObjetoFotos($foto);
                }
            }
            $ocorrencias[] = $novaOcorrencia;
        }

        return ['ocorrencias' => $ocorrencias];
    }

    public static function getOcorrenciaByIdFiltro($id_ocorrencia)
    {

        $ocorrencia = Ocorrencia::select()
            ->Where('id', $id_ocorrencia)
            ->orderBy('data_ocorrencia', 'desc')
            ->orderBy('hora_ocorrencia', 'desc')
            ->one();

        if ($ocorrencia) {
            $novaOcorrencia = OcorrenciaHandler::arrayOcorrenciaParaObjetoOcorrencia($ocorrencia);

            $novoUsuario = Usuario::select()->where('id', $ocorrencia['id_usuario'])->one();
            if ($novoUsuario) {
                $novaOcorrencia->usuario = OcorrenciaHandler::arrayUsuarioParaObjetoUsuario($novoUsuario);
            }

            $envolvidosLista = Envolvido::select()->where('id_ocorrencia', $ocorrencia['id'])->get();
            if ( !empty($envolvidosLista) && count($envolvidosLista) > 0) {
                $novaOcorrencia->envolvidosLista = [];
                foreach ($envolvidosLista as $envolvido) {
                    $novaOcorrencia->envolvidosLista[] = OcorrenciaHandler::arrayEnvolvidoparaObjetoEnvolvido($envolvido);
                }
            }

            $ativosLista = Ativo::select()->where('id_ocorrencia', $ocorrencia['id'])->get();
            if ( !empty($ativosLista) && count($ativosLista) > 0) {
                $novaOcorrencia->ativosLista = [];
                foreach ($ativosLista as $ativo) {
                    $novaOcorrencia->ativosLista[]  = OcorrenciaHandler::arrayAtivoParaObjetoAtivo($ativo);
                }
            }

            $fotosLista = Foto::select()->where('id_ocorrencia', $ocorrencia['id'])->get();
            if (!empty($fotosLista) && count($fotosLista) > 0) {
                $novaOcorrencia->fotosOcorrencias = [];
                foreach ($fotosLista as $foto) {
                    $novaOcorrencia->fotosOcorrencias[] = OcorrenciaHandler::arrayFotosparaObjetoFotos($foto);
                }
            }
            return $novaOcorrencia;
        }
    }

    public static function getBYDocumentoEnvolvimentoOuNome(
        $nomeEnvolvido,
        $numeroDocumentoEnvolvido,
        $envolvimentoEnvolvido,
        $dataInicio,
        $dataFim
    ) {
        $envolvildosEncontrados = EnvolvidoHandler::getBYDocumentoEnvolvimentoOuNome(
            $nomeEnvolvido,
            $numeroDocumentoEnvolvido,
            $envolvimentoEnvolvido,

        );

        $ocorrencias = [];
        if ($envolvildosEncontrados) {
            foreach ($envolvildosEncontrados as $envolvido) {
                $novaOcorrencia = self::getOcorrenciaById($envolvido['id_ocorrencia'], $dataInicio, $dataFim);
                $ocorrencias[] = $novaOcorrencia;
            }
        }

        $ocorrencias = array_filter($ocorrencias, function ($item) {
            return !empty($item);
        });

        usort($ocorrencias, function ($a, $b) {
            return $b->data_ocorrencia <=> $a->data_ocorrencia;
        });

        return  $ocorrencias;
    }

    public static function getOcorrenciaByTipoNatureza($tipo, $natureza, $data_inicio, $data_fim)
    {

        $ocorrenciasLista = Ocorrencia::select()
            ->where('tipo_natureza', $tipo)
            ->where('natureza', $natureza)
            ->where('data_ocorrencia', '>=', $data_inicio)
            ->where('data_ocorrencia', '<=', $data_fim)
            ->orderBy('data_ocorrencia', 'desc')
            ->orderBy('hora_ocorrencia', 'desc')
            ->get();

        $ocorrenciasLista = array_filter($ocorrenciasLista, function ($item) {
            return !empty($item);
        });

        $ocorrencias = [];
        foreach ($ocorrenciasLista as $ocorrenciaItem) {
            $novaOcorrencia = OcorrenciaHandler::arrayOcorrenciaParaObjetoOcorrencia($ocorrenciaItem);

            $novoUsuario = Usuario::select()->where('id', $ocorrenciaItem['id_usuario'])->one();
            if(!empty($novoUsuario) && $novoUsuario){
                $novaOcorrencia->usuario = OcorrenciaHandler::arrayUsuarioParaObjetoUsuario($novoUsuario);
            }
           

            $envolvidosLista = Envolvido::select()->where('id_ocorrencia', $ocorrenciaItem['id'])->get();
            if ( !empty($envolvidosLista) && count($envolvidosLista) > 0) {
                $novaOcorrencia->envolvidosLista = [];
                foreach ($envolvidosLista as $envolvido) {
                    $novaOcorrencia->envolvidosLista[] = OcorrenciaHandler::arrayEnvolvidoparaObjetoEnvolvido($envolvido);
                }
            }

            $ativosLista = Ativo::select()->where('id_ocorrencia', $ocorrenciaItem['id'])->get();
            if ( !empty($ativosLista) && count($ativosLista) > 0) {
                $novaOcorrencia->ativosLista = [];
                foreach ($ativosLista as $ativo) {
                    $novaOcorrencia->ativosLista[] = OcorrenciaHandler::arrayAtivoParaObjetoAtivo($ativo);
                }
            }

            $fotosLista = Foto::select()->where('id_ocorrencia', $ocorrenciaItem['id'])->get();
            if ( !empty($fotosLista) && count($fotosLista) > 0) {
                $novaOcorrencia->fotosOcorrencias = [];
                foreach ($fotosLista as $foto) {
                    $novaOcorrencia->fotosOcorrencias[] = OcorrenciaHandler::arrayFotosparaObjetoFotos($foto);
                }
            }

            $ocorrencias[] = $novaOcorrencia;
        }
        return ['ocorrencias' => $ocorrencias];
    }




    public static function arrayFotosparaObjetoFotos($arrayFotos)
    {
        $novaFoto = new Foto();
        $novaFoto->id = $arrayFotos['id'];
        $novaFoto->nome = $arrayFotos['nome'];
        $novaFoto->url = $arrayFotos['url'];

        return $novaFoto;
    }



    public static function arrayOcorrenciaParaObjetoOcorrencia($arrayOcorrencia)
    {
        $objetoOcorrencia = new Ocorrencia();
        $objetoOcorrencia->id = $arrayOcorrencia['id'];
        $objetoOcorrencia->equipe = $arrayOcorrencia['equipe'];
        $objetoOcorrencia->forma_conhecimento = $arrayOcorrencia['forma_conhecimento'];
        $objetoOcorrencia->data_ocorrencia = $arrayOcorrencia['data_ocorrencia'];
        $objetoOcorrencia->hora_ocorrencia = $arrayOcorrencia['hora_ocorrencia'];
        $objetoOcorrencia->titulo = $arrayOcorrencia['titulo'];
        $objetoOcorrencia->area = $arrayOcorrencia['area'];
        $objetoOcorrencia->local = $arrayOcorrencia['local'];
        $objetoOcorrencia->tipo_natureza = $arrayOcorrencia['tipo_natureza'];
        $objetoOcorrencia->natureza = $arrayOcorrencia['natureza'];
        $objetoOcorrencia->descricao = $arrayOcorrencia['descricao'];
        $objetoOcorrencia->acoes = $arrayOcorrencia['acoes'];

        return $objetoOcorrencia;
    }

    public static function arrayUsuarioParaObjetoUsuario($arrayUsuario)
    {
        $novoUsuario = new Usuario();
        $novoUsuario->id = $arrayUsuario['id'];
        $novoUsuario->nome = $arrayUsuario['nome'];
        $novoUsuario->nivel = $arrayUsuario['nivel'];

        return  $novoUsuario;
    }

    public static function arrayEnvolvidoparaObjetoEnvolvido($arrayEnvolvido)
    {

        $novoEnvolvido = new Envolvido();
        $novoEnvolvido->id = $arrayEnvolvido['id'];
        $novoEnvolvido->nome = $arrayEnvolvido['nome'];
        $novoEnvolvido->tipo_de_documento = $arrayEnvolvido['tipo_de_documento'];
        $novoEnvolvido->numero_documento = $arrayEnvolvido['numero_documento'];
        $novoEnvolvido->envolvimento = $arrayEnvolvido['envolvimento'];
        $novoEnvolvido->vinculo = $arrayEnvolvido['vinculo'];
        $novoEnvolvido->tipo_veiculo = $arrayEnvolvido['tipo_veiculo'];
        $novoEnvolvido->placa = $arrayEnvolvido['placa'];

        return $novoEnvolvido;
    }

    public static function arrayAtivoParaObjetoAtivo($arrayAtivo)
    {
        $novoAtivo = new Ativo();
        $novoAtivo->id = $arrayAtivo['id'];
        $novoAtivo->tipo_ativo = $arrayAtivo['tipo_ativo'];
        $novoAtivo->id_ativo = $arrayAtivo['id_ativo'];
        return  $novoAtivo;
    }

    public static function excluirOcorrencia($id)
    {
        Ocorrencia::delete()->where('id', $id)->execute();
        Envolvido::delete()->where('id_ocorrencia', $id)->execute();
        Ativo::delete()->where('id_ocorrencia', $id)->execute();
        Foto::delete()->where('id_ocorrencia', $id)->execute();
    }

    public static function atualizarOcorrencia(
        $id_ocorrencia,
        $equipe,
        $forma_conhecimento,
        $data_ocorrencia,
        $hora_ocorrencia,
        $titulo,
        $area,
        $local,
        $tipo_natureza,
        $natureza,
        $descricao,
        $acoes,
        $id_usuario
    ) {

        $insertQuery = Ocorrencia::update()
            ->set('equipe', $equipe)
            ->set('forma_conhecimento', $forma_conhecimento)
            ->set('data_ocorrencia', $data_ocorrencia)
            ->set('hora_ocorrencia', $hora_ocorrencia)
            ->set('titulo', $titulo)
            ->set('area', $area)
            ->set('local', $local)
            ->set('tipo_natureza', $tipo_natureza)
            ->set('natureza', $natureza)
            ->set('descricao', $descricao)
            ->set('acoes', $acoes)
            ->where('id', $id_ocorrencia)
            ->execute();

        return $insertQuery;
    }
}
