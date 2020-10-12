<?php

namespace App\Http\Controllers;
use App\Carrito;
use App\Libros;
use App\Eventos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CarritoController extends Controller
{
    public function agregar(){

        $id = $_GET['id'];
        // dd($id);
        $cantidad = $_GET['cantidad'];
        $carrito = new Carrito();
        $libro = Libros::find($id);
 
        if(Auth::user() == null){
            $carrito->books_id = $libro->id;
            $carrito->Cantidad = $cantidad;
            $carrito->session_estatus = $_COOKIE['XSRF-TOKEN'];
            $carrito->Subtotal = $libro->Precio * $cantidad;
        }
        else{
            $carrito->books_id = $libro->id;
            $carrito->user_id = Auth::user()->id;
            $carrito->Cantidad = $cantidad;
            $carrito->Subtotal = $libro->Precio * $cantidad;
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

    public function eliminar($id){
        $book = Carrito::where('books_id',$id);

        $book->delete();

        return back();
    }

    public function agregarEvento(){

        $id = $_GET['id'];
        // dd($id);
        $cantidad = $_GET['cantidad'];
        $carrito = new Carrito();
        $evento = Eventos::find($id);
 
        if(Auth::user() == null){
            $carrito->books_id = $evento->id;
            $carrito->Cantidad = $cantidad;
            $carrito->session_estatus = $_COOKIE['XSRF-TOKEN'];
            $carrito->Subtotal = $evento->Costo * $cantidad;
        }
        else{
            $carrito->eventos_id = $evento->id;
            $carrito->user_id = Auth::user()->id;
            $carrito->Cantidad = $cantidad;
            $carrito->Subtotal = $evento->Costo * $cantidad;
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
}
