<?php

namespace App\Models;

use PDO;

class DataBase
{
    public function conexao()
    {
        $username = "root";
        $password = "";
        $pdo = new PDO('mysql:host=localhost:3306;dbname=apiLumen', $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
}
