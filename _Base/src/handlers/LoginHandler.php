<?php

namespace src\handlers;

use \src\models\Usuario;


class LoginHandler
{

    public static function checkLogin()
    {

        if (!empty($_SESSION['token'])) {
            $token = $_SESSION['token'];
            $data = Usuario::select()->where('token', $token)->one();
            if (count($data) > 0) {

                $usuarioLogado = new Usuario();
                $usuarioLogado->id = $data['id'];
                $usuarioLogado->nome = $data['nome'];
                $usuarioLogado->email = $data['email'];
                $usuarioLogado->senha = $data['senha'];
                $usuarioLogado->nivel = $data['nivel'];
                $usuarioLogado->token = $data['token'];
                $usuarioLogado->status = $data['status'];

                return $usuarioLogado;
            }
        }
        return false;
    }

    public static function verificaLogin($email, $senha)
    {

        $usuario = Usuario::select()
            ->where('email', $email)
            ->where('status', 'Ativo')
            ->one();
        if ($usuario) {

            if (password_verify($senha, $usuario['senha'])) {
                $token = md5(time() . rand(0, 9999) . time());
                Usuario::update()
                    ->set('token', $token)
                    ->where('email', $email)
                    ->execute();
                return $token;
            }
        }

        return false;
    }

    public static function getAllUsuarios()
    {
        $listaUsuarios = Usuario::select()->get();

        return $listaUsuarios;
    }

    public static function alterarStatus($id)
    {
        $usuarioAlterado = [];
        $usuario = Usuario::select()->where('id', $id)->one();

        if ($usuario) {

            if ($usuario['status'] === 'Ativo') {
                $usuarioAlterado =  Usuario::update()
                    ->set('status', 'Inativo')
                    ->where('id', $id)
                    ->execute();
            } else {
                $usuarioAlterado =  Usuario::update()
                    ->set('status', 'Ativo')
                    ->where('id', $id)
                    ->execute();
            }

            return  $usuarioAlterado;
        }

        return false;
    }

    public static function alterarNivelUsuario($id)
    {
        $usuarioAlterado = [];
        $usuario = Usuario::select()->where('id', $id)->one();

        if ($usuario) {

            if ($usuario['nivel'] === 'Administrador') {
                $usuarioAlterado =  Usuario::update()
                    ->set('nivel', 'Usuário')
                    ->where('id', $id)
                    ->execute();
            } else {
                $usuarioAlterado =  Usuario::update()
                    ->set('nivel', 'Administrador')
                    ->where('id', $id)
                    ->execute();
            }

            return  $usuarioAlterado;
        }

        return false;
    }


    public static function resetarSenhaUsuario($id)
    {
        $usuarioAlterado = [];
        $usuario = Usuario::select()->where('id', $id)->one();
        $novaSenha = '123';

        if ($usuario) {

            $hash = password_hash($novaSenha, PASSWORD_DEFAULT);
            $usuarioAlterado =  Usuario::update()
                ->set('senha', $hash)
                ->where('id', $id)
                ->execute();

            return  $usuarioAlterado;
        }

        return false;
    }
}
