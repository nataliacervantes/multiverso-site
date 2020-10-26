<?php

namespace App\Http\Controllers;
use App\Carrito;
use App\Libros;
use App\Eventos;
use App\CostoEnvio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CarritoController extends Controller
{
    public function agregar(){
        
        session_start();
        
        $id = $_GET['id'];
        $cantidad = $_GET['cantidad'];
        // return $cantidad;
        $carrito = Carrito::where('session_estatus',session_id())->where('books_id',$id)->first();
        $libro = Libros::find($id);
        // dd($carrito);
        if($carrito == null ){
            $carrito = new Carrito();

            $carrito->books_id = $libro->id;
            $carrito->Cantidad = $cantidad;
            $carrito->session_estatus = session_id();
            $carrito->Subtotal = $libro->Precio * $cantidad;
            // return $cantidad;
        }else{
            $carrito->Cantidad = $cantidad + $carrito->Cantidad;
            $carrito->Subtotal = $libro->Precio * $carrito->Cantidad ;
        }
            $carrito->save();
        
        if($carrito){
            $exito = 'Hecho';

            // return Redirect::back()->with('status', 'El producto se agregó al Carrito!');
            return $exito;
        }else{
            $fail = 'No se armó';
            // return Redirect::back()->with('status', 'Hubo un problema, inténtalo más tarde!');
            return $fail;
        }
    }

    public function eliminarLibro($id){
        $book = Carrito::where('books_id',$id);

        $book->delete();

        return back();
    }

    public function eliminarEvento($id){
        $evento = Carrito::where('eventos_id',$id);

        $evento->delete();

        return back();
    }

    public function agregarEvento(){

        session_start();
        
        $id = $_GET['id'];
        $cantidad = $_GET['cantidad'];
        $carrito = Carrito::where('session_estatus',session_id())->where('eventos_id',$id)->first();
        $evento = Eventos::find($id);
        // dd($carrito);
        if($carrito == null ){
            $carrito = new Carrito();

            $carrito->eventos_id = $evento->id;
            $carrito->Cantidad = $cantidad;
            $carrito->session_estatus = session_id();
            $carrito->Subtotal = $evento->Costo * $carrito->Cantidad ;
        }else{
            $carrito->Cantidad = $cantidad + $carrito->Cantidad;
            $carrito->Subtotal = $evento->Costo * $carrito->Cantidad ;
        }
            $carrito->save();
        
        if($carrito){
            $exito = 'Hecho';
            return $exito;
        }else{
            $fail = 'No se armó';
            return $fail;
        }
    }

    public function checkout(){
        session_start();
        $carrito = Carrito::where('session_estatus',session_id())->get();
        session_destroy();
        return view('checkout.list', compact('carrito'));
    }

    public function formEnvio(Request $request){
        dd($request->all());
    }

    public function calcularEnvio(){
        $pais = $_GET['pais'];
        // $costo = CostoEnvio::first();
        $costoEnvio = CostoEnvio::where('Pais', $pais)->first();
        $costo = $costoEnvio->Costo;
        // dd($costo);
        return $costo;
    }
}
