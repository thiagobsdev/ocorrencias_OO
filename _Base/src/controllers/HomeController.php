<?php

namespace src\controllers;

use \core\Controller;
use \src\models\Usuario;
use \src\handlers\LoginHandler;
use \src\handlers\OcorrenciaHandler;

class HomeController extends Controller
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
    
    public function index()
    {
        $page = intval(filter_input(INPUT_GET, 'page'));
        $ocorrencias = OcorrenciaHandler::getAllOcorrencias($page);

        $this->render('home', [
            'usuariologado' => $this->usuarioLogado,
            'ocorrencias' => $ocorrencias
        ]);
    }

    public function imprimirOcorrencia($id_ocorrencia)
    {
        $idOcorrencia = intval($id_ocorrencia['id']);

        $ocorrencia = OcorrenciaHandler::getOcorrenciaById($idOcorrencia);

        $this->render('gerarPDF', [
            'usuariologado' => $this->usuarioLogado,
            'ocorrencia' => $ocorrencia
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
