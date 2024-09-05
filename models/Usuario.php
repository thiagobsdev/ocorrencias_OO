<?php

namespace src\models;

use \core\Model;

class Usuario
{
     public $id;
     public $nome;
     public $email;
     public $senha;
     public $nivel;
     public $token;
     public $status;
}

interface UserDAO
{
     public function findByToken($token);
     public function findByEmail($email);
     public function update(Usuario $user);
}
