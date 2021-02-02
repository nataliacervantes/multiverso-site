<?php

namespace App\Http\Controllers;
use App\Reto;
use Illuminate\Http\Request;

class RetoController extends Controller
{
    public function index(){
        $retos = Reto::all();

        return view('reto.list', compact('retos'));
    }
}
