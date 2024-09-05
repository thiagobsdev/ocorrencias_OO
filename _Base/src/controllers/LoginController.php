<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\LoginHandler;

class LoginController extends Controller {

    public function entrar() {
        $flash= "";
        if(!empty($_SESSION['flash'])){
            $flash = $_SESSION['flash'];
            $_SESSION['flash']="";
        }

        $this->render('login', 
            ['flash' => $flash]);
    }

    public function entrarAction(){
        $email = filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL);
        $senha = filter_input(INPUT_POST,'senha');

        if($email && $senha) {
            $token = LoginHandler::verificaLogin($email, $senha);
           if($token) {
                $_SESSION['token']=$token;
                $this->redirect('/');
            }else{
                $_SESSION['flash']="email e/ou senha invalidos ou inativo!";
                $this->redirect('/login');
            }

        }else {
            $_SESSION['flash']="Digite os campos de email e senha!";
            $this->redirect('/login');
        }
    }

    public function sair () {
        $_SESSION['token']="";
        $this->redirect('/login');
    }


}