<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Newsletter;
use Illuminate\Support\Facades\Mail;
use App\Mail\SuscripcionMultiverso;

class IndexController extends Controller
{
    public function suscripcion(Request $request){
        $suscripcion = Newsletter::create($request->all());
        
        Mail::to($request->Email)->send(new SuscripcionMultiverso());
        $value = session(['key' => 'la madre']);
        return back();
    }

    public function desactivarModal(Request $request){
        $value = session(['key' => 'la madre']);
    }

    public function politicas(){
        return view('files.politica');
    }

    public function terminos(){
        return view('files.terminos');
    }
}
