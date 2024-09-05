<?php

namespace src\controllers;

use \core\Controller;
use DateTime;
use \src\models\Usuario;
use \src\handlers\LoginHandler;
use \src\handlers\OcorrenciaHandler;

class PesquisaController extends Controller
{

    private $usuarioLogado;


    public function __construct()
    {
        $this->setUsuarioLogado(LoginHandler::checkLogin());
        if ($this->usuarioLogado === false) {
            $this->redirect('/login');
        } else {
            $this->usuarioLogado = Usuario::select()->where('token', $_SESSION['token'])->one();
        }
    }

    public function pesquisarDatas()
    {

        $dataInicio = filter_input(INPUT_GET, 'dataInicio');
        $dataFim = filter_input(INPUT_GET, 'dataFim');

        ($dataInicio === "") ? $dataInicio = '1990-01-01' : $dataInicio;
        ($dataFim === '') ?  $dataFim = '2100-12-31' : $dataFim;


        $ocorrencias = OcorrenciaHandler::getOcorrenciaByIdEDatas($dataInicio,  $dataFim);

        if (!empty($ocorrencias)) {

            $this->render('pesquisa_datas', [
                'usuariologado' => $this->usuarioLogado,
                'ocorrencias' => $ocorrencias
            ]);
        } else {
            $this->redirect('/');
        }
    }

    public function pesquisarPorId()
    {
        $this->render('pesquisa_id card', [
            'usuariologado' => $this->usuarioLogado,
        ]);
    }

    public function pesquisarPorIdAction()
    {
        $idOcorrencia = abs(intval(filter_input(INPUT_POST, 'id_ocorrencia')));

        ($idOcorrencia > 0) ? $idOcorrencia : '*';

        $ocorrencia = OcorrenciaHandler::getOcorrenciaByIdFiltro($idOcorrencia);

        $this->render('pesquisa_id', [
            'usuariologado' => $this->usuarioLogado,
            'ocorrencia' => $ocorrencia
        ]);
    }

    public function pesquisarPorEnvolvido()
    {
        $this->render('pesquisa_envolvido card', [
            'usuariologado' => $this->usuarioLogado,
        ]);
    }

    public function pesquisarPorEnvolvidoAction()
    {
        $nomeEnvolvido = filter_input(INPUT_POST, 'nomeEnvolvido');
        $numeroDocumentoEnvolvido = filter_input(INPUT_POST, 'numeroDocumentoEnvolvido');
        $envolvimentoEnvolvido = filter_input(INPUT_POST, 'envolvimentoEnvolvido');
        $dataInicio = filter_input(INPUT_POST, 'dataInicio');
        $dataFim = filter_input(INPUT_POST, 'dataFim');

        ($dataInicio === "") ? $dataInicio = '1990-01-01' : $dataInicio;
        ($dataFim === '') ?  $dataFim = '2100-12-31' : $dataFim;


        ($nomeEnvolvido !== "") ? $nomeEnvolvido : $nomeEnvolvido = '*';
        ($numeroDocumentoEnvolvido !== "") ?  $numeroDocumentoEnvolvido : $numeroDocumentoEnvolvido = '*';
        ($envolvimentoEnvolvido !== "") ? $envolvimentoEnvolvido :  $envolvimentoEnvolvido = '*';


        $ocorrencias = OcorrenciaHandler::getBYDocumentoEnvolvimentoOuNome(
            $nomeEnvolvido,
            $numeroDocumentoEnvolvido,
            $envolvimentoEnvolvido,
            $dataInicio,
            $dataFim
        );

        $this->render('pesquisa_envolvido', [
            'usuariologado' => $this->usuarioLogado,
            'ocorrencias' => $ocorrencias
        ]);
    }

    public function pesquisarPorTipoNatureza()
    {
        $this->render('pesquisa_tipo_natureza card', [
            'usuariologado' => $this->usuarioLogado,
        ]);
    }

    public function pesquisarPorTipoNaturezaAction()
    {
        $tipo = filter_input(INPUT_POST, 'tipo_natureza');
        $natureza = filter_input(INPUT_POST, 'natureza');

        $dataInicio = filter_input(INPUT_POST, 'dataInicio');
        $dataFim = filter_input(INPUT_POST, 'dataFim');

        ($dataInicio === "") ? $dataInicio = '1990-01-01' : $dataInicio;
        ($dataFim === '') ?  $dataFim = '2100-12-31' : $dataFim;


        $ocorrencias = OcorrenciaHandler::getOcorrenciaByTipoNatureza($tipo, $natureza, $dataInicio, $dataFim);
       $this->render('pesquisa_tipo_natureza', [
            'usuariologado' => $this->usuarioLogado,
            'ocorrencias' => $ocorrencias
        ]); 
    }


    public function getUsuarioLogado()
    {
        return $this->usuarioLogado;
    }

    public function setUsuarioLogado($usuario)
    {
        $this->usuarioLogado = $usuario;
    }
}
