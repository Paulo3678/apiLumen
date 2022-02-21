<?php

namespace App\Models;

use Exception;
use PDOException;
use App\Models\DataBase;

class UserFactory
{
    public function __construct()
    {
        $this->pdo = (new DataBase())->conexao();
    }

    public function newUser($nome, $idade, $email, $senha)
    {
        try {
            $query = "INSERT INTO user (nome, idade, email, senha) VALUES (:nome, :idade, :email, :senha)";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(":nome", $nome, $this->pdo::PARAM_STR);
            $stmt->bindValue(":idade", $idade, $this->pdo::PARAM_STR);
            $stmt->bindValue(":email", $email, $this->pdo::PARAM_STR);
            $stmt->bindValue(":senha", $senha, $this->pdo::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function findallUsers()
    {
        $query = $this->pdo->query("SELECT * FROM user");
        $listaDeAlunos = $query->fetchAll($this->pdo::FETCH_ASSOC);
        return $listaDeAlunos;
    }

    public function findById($id)
    {
        $query = $this->pdo->query("SELECT * FROM user WHERE id=" . $id);
        $listaDeAlunos = $query->fetch($this->pdo::FETCH_ASSOC);
        return $listaDeAlunos;
    }

    public function removeUser($id)
    {
        return $this->pdo->exec("DELETE FROM user WHERE id=" . $id);
    }
}
