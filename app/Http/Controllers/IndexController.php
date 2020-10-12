<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Newsletter;

class IndexController extends Controller
{
    public function suscripcion(Request $request){
        $suscripcion = Newsletter::create($request->all());

        return back();
    }
}
