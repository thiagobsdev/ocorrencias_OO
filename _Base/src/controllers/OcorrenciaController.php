<?php

namespace src\controllers;

use \core\Controller;

use src\handlers\AtivosHandler;
use \src\handlers\LoginHandler;
use \src\handlers\OcorrenciaHandler;
use \src\handlers\EnvolvidoHandler;
use \src\handlers\FotosHandler;
use \src\models\Usuario;

class OcorrenciaController extends Controller
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

    public function cadastrarOcorrencia()
    {

        $flash = "";
        if (!empty($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = "";
        }

        $this->render(
            'novaocorrencia',
            [
                'flash' => $flash,
                'usuariologado' => $this->usuarioLogado
            ]
        );
    }

    public function cadastrarOcorrenciaAction()
    {

        $equipe =  filter_input(INPUT_POST, 'equipe');
        $forma_conhecimento =  filter_input(INPUT_POST, 'forma_conhecimento', FILTER_SANITIZE_SPECIAL_CHARS);
        $data_ocorrencia =  filter_input(INPUT_POST, 'data_ocorrencia');
        $hora_ocorrencia =  filter_input(INPUT_POST, 'hora_ocorrencia');
        $titulo =  filter_input(INPUT_POST, 'titulo');
        $area =  filter_input(INPUT_POST, 'area');
        $local =  filter_input(INPUT_POST, 'local');
        $tipo_natureza =  filter_input(INPUT_POST, 'tipo_natureza');
        $natureza =  filter_input(INPUT_POST, 'natureza');
        $descricao =  filter_input(INPUT_POST, 'descricao');
        $acoes =  filter_input(INPUT_POST, 'acoes');
        $id_usuario = $this->usuarioLogado;
        $envolvidos = $_POST['envolvidos'];
        $ativos = $_POST['ativos'];
        $arquivosFotos = $_FILES['fotos'];



        if (
            $equipe &&
            $forma_conhecimento &&
            $data_ocorrencia &&
            $hora_ocorrencia &&
            $titulo &&
            $area &&
            $local &&
            $tipo_natureza &&
            $natureza &&
            $descricao
        ) {
            $id_ocorrencia = OcorrenciaHandler::addOcorrencia(
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
                $id_usuario['id']


            );
            if ($id_ocorrencia && !empty($envolvidos)) {
                $lista =  EnvolvidoHandler::addEnvolvidos($id_ocorrencia, $envolvidos);
                
            }
            
           if ($id_ocorrencia && !empty($ativos)) {
                AtivosHandler::addAtivos($id_ocorrencia, $ativos);
            }
            if (count($arquivosFotos['name']) > 0 && $id_ocorrencia) {
                FotosHandler::addFotos($arquivosFotos,  $data_ocorrencia, $id_ocorrencia, $id_usuario['id']);
            }

            $_SESSION['flash'] = "Ocorrencia cadastrada com sucesso!";
            $this->redirect('/nova_ocorrencia');
        } else {
            $_SESSION['flash'] = "Preencha os campos!";
            $this->redirect('/nova_ocorrencia');
        }
    }


    public function excluirOcorrenciaAction()
    {
        $array = ['error' => ''];

        $id = intval(filter_input(INPUT_POST, 'id'));

        if ($id) {
            OcorrenciaHandler::excluirOcorrencia($id);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erro ao excluir a ocorrência']);
        }
    }

    public function excluirEnvolvidoOcorrenciaAction()
    {
        $array = ['error' => ''];

        $id = intval(filter_input(INPUT_POST, 'id'));

        if ($id) {
            EnvolvidoHandler::excluirEnvolvido($id);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erro ao excluir a ocorrência']);
        }
    }

    public function excluirAtivoOcorrenciaAction()
    {
        $array = ['error' => ''];

        $id = intval(filter_input(INPUT_POST, 'id'));

        if ($id) {
            AtivosHandler::excluirAtivo($id);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erro ao excluir a ocorrência']);
        }
    }

    public function excluirFotoOcorrenciaAction()
    {
        $array = ['error' => ''];

        $id = intval(filter_input(INPUT_POST, 'id'));

        if ($id) {
            FotosHandler::excluirFoto($id);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erro ao excluir a ocorrência']);
        }
    }






    public function editarOcorrencia($id)
    {
        $idOcorrencia = intval($id['id']);

        $ocorrencia = OcorrenciaHandler::getOcorrenciaById($idOcorrencia);

        $this->render('editarOcorrencia', [
            'usuariologado' => $this->usuarioLogado,
            'ocorrencia' => $ocorrencia
        ]);
    }

    public function editarOcorrenciaAction($id)
    {
        $id_ocorrencia =  intval($id['id']);
        $equipe =  filter_input(INPUT_POST, 'equipe');
        $forma_conhecimento =  filter_input(INPUT_POST, 'forma_conhecimento', FILTER_SANITIZE_SPECIAL_CHARS);
        $data_ocorrencia =  filter_input(INPUT_POST, 'data_ocorrencia');
        $hora_ocorrencia =  filter_input(INPUT_POST, 'hora_ocorrencia');
        $titulo =  filter_input(INPUT_POST, 'titulo');
        $area =  filter_input(INPUT_POST, 'area');
        $local =  filter_input(INPUT_POST, 'local');
        $tipo_natureza =  filter_input(INPUT_POST, 'tipo_natureza');
        $natureza =  filter_input(INPUT_POST, 'natureza');
        $descricao =  filter_input(INPUT_POST, 'descricao');
        $acoes =  filter_input(INPUT_POST, 'acoes');
        $id_usuario = $this->usuarioLogado;
        $envolvidos = isset($_POST['envolvidos']) ? $_POST['envolvidos'] : null;
        $ativosLista = isset($_POST['ativos']) ? $_POST['ativos'] : null;
        $arquivosFotos = isset($_FILES['fotos']) ? $_FILES['fotos'] : null;


        if (
            $id_ocorrencia &&
            $equipe &&
            $forma_conhecimento &&
            $data_ocorrencia &&
            $hora_ocorrencia &&
            $titulo &&
            $area &&
            $local &&
            $tipo_natureza &&
            $natureza &&
            $descricao
        ) {
            $id_ocorrenciaAtualizada = OcorrenciaHandler::atualizarOcorrencia(
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
                $id_usuario['id']
            );

            if ($id_ocorrencia && !empty($envolvidos)) {
                EnvolvidoHandler::atualizarEnvolvidosEdit($id_ocorrencia, $envolvidos);
            }

            if ($id_ocorrencia && !empty($envolvidos)) {
                AtivosHandler::atualizarEnvolvidosEdit($id_ocorrencia, $ativosLista);
            }


            if ($arquivosFotos && $id_ocorrencia) {
                FotosHandler::addFotos($arquivosFotos,  $data_ocorrencia, $id_ocorrencia, $id_usuario['id']);
            }
            $_SESSION['flash'] = "Ocorrencia editada com sucesso!";
            $this->redirect('/');
        }
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
