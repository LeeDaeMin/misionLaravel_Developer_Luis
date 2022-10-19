<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeliculasController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'auth'
], function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);
});

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});

Route::group([
    'prefix' => 'peliculas',

], function() {
    Route::group([
        'middleware' => ['auth:api', 'role:Admin']
    ], function () {

        Route::post('/', [PeliculasController::class, 'create']);
        Route::put('/{id}', [PeliculasController::class, 'update']);
        Route::delete('/{id}', [PeliculasController::class, 'destroy']);
    });

    //lista

    Route::group([
        'middleware'=>(['auth:api','permission:Lista peliculas'])
    ], function (){
        Route::get('/', [PeliculasController::class, 'index']);
        Route::get('/{id}', [PeliculasController::class, 'show']);
    });

    //info

    Route::group([
        'middleware'=>(['auth:api','permission:Informacion de la pelicula'])
    ], function(){
        Route::get('/{id}/info', [PeliculasController::class, 'info']);
    });

    //search

    Route::group([
        'middleware' => ['auth:api', 'permission:Busqueda de peliculas']
    ], function(){
        Route::get('/search/{name}', [PeliculasController::class, 'search']);
    });

    //filter

    Route::group([
        'middleware' => ['auth:api', 'permission:Filtra peliculas por genero']
    ], function(){
        Route::get('/filter/{genre}', [PeliculasController::class, 'filter']);
    });


});






