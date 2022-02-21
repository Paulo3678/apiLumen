<?php

namespace App\Http\Controllers;

use App\Models\DataBase;
use App\Models\UserFactory;
use Error;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use PDOException;

class Index extends Controller
{
    private $userFactory;

    public function __construct()
    {
        $this->userFactory = new UserFactory();
    }

    public function buscarTodos()
    {
        return response()->json($this->userFactory->findallUsers(), 200);
    }

    public function buscarUm()
    {
        var_dump($this->userFactory->findById(1));
    }

    public function novoUser(Request $request)
    {
        if (
            !isset($request->nome) ||
            !isset($request->idade) ||
            !isset($request->email) ||
            !isset($request->senha)
        ) {
            return response()->json([
                "Dados insuficientes"
            ], 416);
        }

        $nome = $request->nome;
        $idade = $request->idade;
        $email = $request->email;
        $senha = $request->senha;

        $return = $this->userFactory->newUser($nome, $idade, $email, $senha);

        if ($return !== true) {
            return response()->json([
                "Erro ao inserir usuário, tente novamente mais tarde"
            ], 500);
        }

        return response()->json([
            "Usuário inserido com sucesso"
        ], 200);
    }


}
