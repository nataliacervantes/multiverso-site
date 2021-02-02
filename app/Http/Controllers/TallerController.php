<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Taller;
class TallerController extends Controller
{
    public function index(){
        $talleres = Taller::all();

        return view('taller.list', compact('talleres'));
    }
}
