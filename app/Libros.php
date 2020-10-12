<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Libros extends Model
{
    protected $table = 'books';
    // protected $fillable = [ 'path'];

    public function getUtlPathAttribute($path){
        return Storage::url($path);
    }

    public function autores()
   {
       return $this->belongsTo(Escritores::class);
   }
}
