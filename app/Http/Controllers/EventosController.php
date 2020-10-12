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
}
