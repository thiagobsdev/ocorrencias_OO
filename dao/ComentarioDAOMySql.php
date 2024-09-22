<?php

require_once 'models/Comentario.php';

use src\models\comentarioDAO;
use src\models\Comentario;



class ComentarioDAOMySql implements comentarioDAO
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function arrayComentarioParaObjetoComentario($array)
    {

        $novoComentario = new Comentario();
        $novoComentario->id = $array['id'] ?? 0;
        $novoComentario->texto = $array['texto'] ?? "";
        $novoComentario->id_ocorrencia = $array['id_ocorrencia'] ?? "";
        $novoComentario->usuario = $array['id_usuario'] ?? "";

        return $novoComentario;
    }

    public function cadastrarComentario($texto, $id_ocorrencia, $usuario)
    {

        if (!empty($texto) && !empty($id_ocorrencia) && !empty($usuario)) {

            $sql = $this->pdo->prepare("INSERT INTO comentarios
             (texto,
             id_ocorrencia, 
             id_usuario) 
             VALUES (:texto,:id_ocorrencia, :id_usuario)");
            $sql->bindValue(':texto', $texto);
            $sql->bindValue(':id_ocorrencia', $id_ocorrencia);
            $sql->bindValue(':id_usuario', $usuario);

            $sql->execute();

            $ultimoId = $this->pdo->lastInsertId();
            return $ultimoId;
        }

        return false;
    }

    public function listarComentariosByIdOcorrencia($id_ocorrencia)
    {

        if ($id_ocorrencia) {
            $sql = $this->pdo->query("SELECT * FROM comentarios WHERE id_ocorrencia = $id_ocorrencia ORDER BY data_comentario DESC");
            $dataComentarios = $sql->fetchAll(PDO::FETCH_ASSOC);
            foreach ($dataComentarios as $index => $comentario) {
                $novoUsuarioDAO = new UserDAOMySql($this->pdo);
                $usuario =  $novoUsuarioDAO->findById($comentario['id_usuario']);
                $dataComentarios[$index]['id_usuario'] = $usuario;
            }
            return $dataComentarios;
        }
        return false;
    }

    public function excluirComentario($comentario_id)
    {
        if ($comentario_id) {
            $sql = $this->pdo->prepare("DELETE FROM comentarios WHERE id = :comentario_id");
            $sql->bindValue(':comentario_id', $comentario_id);
            $sql->execute();
        }
    }
}
