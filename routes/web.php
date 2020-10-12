<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();
Route::get('/', function () {
    return view('welcome');
});

Route::get('/', 'HomeController@index')->name('home');

Route::get('catalogo','CatalogoController@index');
Route::get('eventos','EventosController@index');
Route::get('detalle/{id}','CatalogoController@detalle');
Route::get('escritor/{nombre}','CatalogoController@escritor');
Route::get('getImage/{id}','CatalogoController@getImage');
Route::get('agregarCarrito','CarritoController@agregar');
Route::get('agregarEvento','CarritoController@agregarEvento');
Route::post('suscribirse','IndexController@suscripcion');
Route::get('eliminarLibro/{id}','CarritoController@eliminar');

Route::group(['middleware' => 'auth'], function () {
   Route::post('agregarComentario', 'ComentariosController@create');
});


