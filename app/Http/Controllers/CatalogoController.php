<?php

namespace App\Http\Controllers;
use App\Libros;
use App\Comentarios;
use App\Escritores;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

class CatalogoController extends Controller
{
    public function index(){
        $autores = Escritores::all();
        $suma=0;
           
        return view('libros.catalogo',compact('autores'));
    }

    public function getImage($id){
        $libro = Libros::find($id);
  
        $path = $libro->Imagenes->store('public/images');
        // Libros::create(['path'=>$path]);
    }

    public function detalle($id){
        $libro = Libros::find($id);
        $comentarios = Comentarios::where('books_id',$id)->get();
        $suma=0;
        // dd($comentarios);
            if($comentarios->count() > 0){
                foreach($comentarios as $comments){
                    $suma = $suma+$comments->Star_rating;
                }
                $promedio=$suma/ count($comentarios);
            }else{
                $promedio=0;
            }
        
        // dd($promedio);
        return view('libros.detalle')->with(['libro'=>$libro,'comentarios'=>$comentarios,'promedio'=>$promedio]);
    }

    public function escritor($nombre){
        $escritor = Escritores::where('Nombre',$nombre)->first();

        return view('libros.escritor',compact('escritor'));
    }

    public function getDataLibro($id){
        $libro = Libros::find($id);
        
        return $libro->Portada;
    }
    public function getDataContra($id){
        $libro = Libros::find($id);
        
        return $libro->Contraportada;
    }
}
