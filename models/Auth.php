<?php
require_once 'dao/UserDAOMySql.php';

class Auth
{

    private $pdo;
    private $base;

    public function __construct(PDO $pdo, $base)
    {
        $this->pdo = $pdo;
        $this->base = $base;
    }

    public function checkToken()
    {
        if (!empty($_SESSION['token'])) {
            $token = $_SESSION['token'];

            $userDAO = new UserDAOMySql($this->pdo);
            $user = $userDAO->findByToken($token);

            if ($user) {
                return $user;
            }
        }

        header("Location: " . $this->base . "login.php");
        exit;
    }

    public function validateLogin($email, $senha)
    {
        $userDAO = new UserDAOMySql($this->pdo);

        $user = $userDAO->findByEmail($email);
        if ($user) {
            if (password_verify($senha, $user->senha)) {
                $token = md5(time() . rand(0, 9999));
                $_SESSION['token'] = $token;
                $user->token = $token;
                $userDAO->update($user);

                return true;
            }
        }

        return false;
    }
}
