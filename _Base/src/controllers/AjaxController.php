<?php
namespace src\controllers;

use \core\Controller;
use src\handlers\LoginHandler;
use \src\models\Usuario;


class AjaxController extends Controller {

    public  $usuarioLogado;

    public function __construct(){
        $this->usuarioLogado = LoginHandler::checkLogin();
        if($this->usuarioLogado=== false) {
           header("Content-Type: application/json");
           echo json_encode(['error'=>'usuario não logado']);
           exit;
        }
        
    }

    public function salvarComentario(){
        
    }
    

  


    

}