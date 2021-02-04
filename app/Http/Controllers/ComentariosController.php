<?php

namespace App\Http\Controllers;
use App\Comentarios;
use App\User;
use Illuminate\Http\Request;

class ComentariosController extends Controller
{
    public function create(Request $request){
        // dd($request->all());
        $validatedData = $request->validate([
            'Star_rating' => 'required',
            'Comentario' => 'required',
            'Nombre' => 'required',
            'email' =>'required|email',
        ]);


        $coments = new Comentarios();
        // $user = User::where('email',$request->email)->first();
        // dd($request->all());
        // if($user != null){
            $coments->books_id = $request->books_id;
            $coments->Comentario = $request->Comentario;
            $coments->email =$request->email;
            $coments->Nombre = $request->Nombre;
            $coments->Star_rating = $request->Star_rating;
            $coments->save();
        // }
        // else{
            // echo 'Es necesario que te registres para poder agregar comentarios';
        // }
        return back();
    }
}
