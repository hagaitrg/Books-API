<?php

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

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->group(['prefix' => 'v1'], function () use ($router) {
        $router->get('book/{id}', 'BookController@show');
        $router->get('book', 'BookController@index');
        $router->post('book/store', 'BookController@store');
        $router->put('book/update/{id}', 'BookController@update');
        $router->delete('book/delete/{id}', 'BookController@destroy');

        $router->post('user/register', 'UserController@register');
    });
});