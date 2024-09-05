<?php

require_once 'models/Usuario.php';

use src\models\UserDAO;
use src\models\Usuario;

class UserDAOMySql implements UserDAO
{

    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    private function generateUser($array)
    {
        $novoUsuario = new Usuario();
        $novoUsuario->id = $array['id'] ?? 0;
        $novoUsuario->nome = $array['nome'] ?? "";
        $novoUsuario->email = $array['email'] ?? "";
        $novoUsuario->senha = $array['senha'] ?? "";
        $novoUsuario->nivel = $array['nivel'] ?? "";
        $novoUsuario->token = $array['token'] ?? "";
        $novoUsuario->status = $array['status'] ?? "";

        return $novoUsuario;
    }

    public function findByToken($token)
    {
        if (!empty($token)) {
            $sql = $this->pdo->prepare("SELECT * FROM usuarios WHERE token=:token");
            $sql->bindValue(':token', $token);
            $sql->execute();
        }

        if ($sql->rowCount() > 0) {
            $data = $sql->fetch(PDO::FETCH_ASSOC);
            $user = $this->generateUser($data);
            return $user;
        }

        return false;
    }

    public function findByEmail($email)
    {
        if (!empty($email)) {
            $sql = $this->pdo->prepare("SELECT * FROM usuarios WHERE email=:email");
            $sql->bindValue(':email', $email);
            $sql->execute();
        }
        if ($sql->rowCount() > 0) {
            $data = $sql->fetch(PDO::FETCH_ASSOC);
            $user = $this->generateUser($data);
            return $user;
        }
        return false;
    }

    public function update(Usuario  $user)
    {
        if (!empty($user)) {
            $sql = $this->pdo->prepare("UPDATE usuarios SET 
            nome = :nome,
            email = :email,
            senha = :senha,
            nivel = :nivel,
            token = :token,
            status = :status

             WHERE id=:id");

            $sql->bindValue(':nome', $user->nome);
            $sql->bindValue(':email', $user->email);
            $sql->bindValue(':senha', $user->senha);
            $sql->bindValue(':nivel', $user->nivel);
            $sql->bindValue(':token', $user->token);
            $sql->bindValue(':status', $user->status);
            $sql->bindValue(':id', $user->id);

            $sql->execute();

            return true;
        }
    }

    public function cadastrarUsuario(Usuario $user)
    {
        if (!empty($user)) {

            $emailExistente = $this->findByEmail($user->email);

            if (empty($emailExistente)) {

                $hash = password_hash($user->senha, PASSWORD_DEFAULT);
                $sql = $this->pdo->prepare("INSERT INTO usuarios
                 (nome,email, senha, nivel,status ) 
                 VALUES (:nome, :email, :senha, :nivel, :status)");
                $sql->bindValue(':nome', $user->nome);
                $sql->bindValue(':email', $user->email);
                $sql->bindValue(':senha', $hash);
                $sql->bindValue(':nivel', $user->nivel);
                $sql->bindValue(':status', $user->status);
                $sql->execute();

                $ultimoId = $this->pdo->lastInsertId();
                $sql = $this->pdo->prepare("SELECT * FROM usuarios WHERE id = :id");
                $sql->bindValue(':id', $ultimoId);
                $sql->execute();
                
                if ($sql->rowCount() > 0) {
                    $data = $sql->fetch(PDO::FETCH_ASSOC);
                    $user = $this->generateUser($data);
                    return $user;
                }
            }
        }

        return false;
    }
}
