<?php

namespace App\Http\Controllers;
use App\Eventos;
use Illuminate\Http\Request;

class EventosController extends Controller
{
    public function index(){
        $eventos = Eventos::all();
        return view('eventos.list', compact('eventos'));
    }

    public function buscar(Request $request){
        
        $eventos = Eventos::where('Lugar','like',"%$request->buscar%")
                            ->orWhere('Evento','like',"%$request->buscar%")
                            ->orWhere('Estado','like',"%$request->buscar%")->get();
        // dd($eventos);
        return view('eventos.list', compact('eventos'));
    }

    public function buscarFecha(Request $request){
        
        $eventos = Eventos::where('Fecha','like',"%$request->buscar%")->get();
        // dd($eventos);
        return view('eventos.list', compact('eventos'));
    }
}
