<?php

namespace App\Http\Controllers;

use App\Models\UserFactory;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;

class Autenticacao extends Controller
{
    private $userFactory;

    public function __construct()
    {
        $this->userFactory = new UserFactory();
    }

    public function login(Request $request)
    {
        $email = $request->email;
        $senha = $request->senha;

        $user = $this->userFactory->findOneByEmail($email);

        $token = JWT::encode(["userName" => $user['nome'], "userId" => $user['id'], "userEmail" => $user['email']], env('TOKEN_KEY'), "HS256");
        return response()->json([
            "token" => $token
        ], 200);
    }
}
