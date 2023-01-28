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
$router->get('users', 'UsersController@index');

// Pasien
Route::group(['middleware' => ['auth']], function ($router){
$router->get('pasien', 'PasiensController@index');
$router->get('/pasiens', 'PasiensController@index');
$router->post('/pasiens', 'PasiensController@store');
$router->get('/pasiens/{id}', 'PasiensController@show');
$router->put('/pasiens/{id}', 'PasiensController@update');
$router->delete('/pasiens/{id}','PasiensController@destroy');
});


// Rekam medis
Route::group(['middleware' => ['auth']], function ($router){
$router->get('rekammedis', 'rekammedisController@index');
$router->get('/rekammedis', 'rekammedisController@index');
$router->post('/rekammedis', 'rekammedisController@store');
$router->get('/rekammedis/{id}', 'rekammedisController@show');
$router->put('/rekammedis/{id}', 'rekammedisController@update');
$router->delete('/rekammedis/{id}','rekammedisController@destroy');
});

// authentication
$router->group(['prefix' => 'auth'], function () use ($router) {
    // Matches "/api/register
    $router->post('/register', 'AuthController@register');
    $router->post('/login', 'AuthController@login');
});