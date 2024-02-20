<?php

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

use Laravel\Lumen\Routing\Router;

/** @var Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('login', 'UserController@login');

    $router->group(['middleware' => 'auth'], function () use ($router) {

        $router->get('validate', function () {
            return request()->user();
        });

        $router->group(['prefix' => 'todo'], function () use ($router){
            $router->get('/', 'TodoController@index');
            $router->post('/', 'TodoController@store');
            $router->put('/{id}', 'TodoController@update');
            $router->delete('/{id}', 'TodoController@destroy');
        });
    });
});
