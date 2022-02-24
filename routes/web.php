<?php

use App\Http\Controllers\Index;
use App\Http\Controllers\Autenticacao;

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->post("/api/login", "Autenticacao@login");

$router->group(['prefix' => 'api/', 'middleware' => "auth"], function () use ($router) {
    $router->get("user", "Index@buscarTodos");
    $router->post("user", "Index@novoUser");
    $router->get("user/{id}", "Index@buscarUm");
    $router->delete("user/{id}", "Index@removerUser");
});
