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
// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', 'HomeController@index')->name('home');

Route::get('/','CatalogoController@index');
Route::get('catalogo','CatalogoController@index');
Route::get('eventos','EventosController@index');
Route::get('talleres','TallerController@index');
Route::get('retos','RetoController@index');
Route::get('detalle/{id}','CatalogoController@detalle');
Route::get('escritor/{nombre}','CatalogoController@escritor');
Route::get('getImage/{id}','CatalogoController@getImage');
Route::get('agregarCarrito','CarritoController@agregar');
Route::get('agregarEvento','CarritoController@agregarEvento');
Route::post('suscribirse','IndexController@suscripcion');
Route::get('eliminarLibro/{id}','CarritoController@eliminarLibro');
Route::get('eliminarEvento/{id}','CarritoController@eliminarEvento');
Route::post('agregarComentario', 'ComentariosController@create');
Route::get('checkout','CarritoController@checkout');
Route::post('formEnvio','CarritoController@formEnvio');
Route::get('calcularEnvio','CarritoController@calcularEnvio');
Route::post('realizarPedido','PedidosController@crearPedido');
Route::any('payWithPaypal','PayPalController@payWithPaypal');
Route::get('paypal/status','PayPalController@paypalStatus');
Route::get('pagoExitoso','PayPalController@exito');
Route::get('fail','PayPalController@fail');
Route::post('depositoBancario','PayPalController@deposito');
Route::get('subirFicha','PedidosController@subirFicha');
Route::post('subirFichaPago','PedidosController@subirFichaPago');
Route::get('buscarEvento','EventosController@buscar');
Route::get('buscarFecha','EventosController@buscarFecha');
Route::get('aplicarCupon','PedidosController@cupon');
Route::get('confirmacionPagoMP','MercadoPagoController@confirmacionPagoMP');
Route::any('mercadoPagoPay','MercadoPagoController@mercadoPagoPay');
Route::get('desactivarModal','IndexController@desactivarModal');
Route::get('getDataLibro/{id}','CatalogoController@getDataLibro');
Route::get('getDataContra/{id}','CatalogoController@getDataContra');
Route::get('iframe/{id}','CatalogoController@getIframe');
Route::get('boleto',function(){
    $pdf = PDF::loadView('emails.boleto_virutal');
    $pdf->download();
});
// Route::group(['middleware' => 'auth'], function () {

// });


