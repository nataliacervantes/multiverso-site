<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Escritores extends Model
{
    protected $table = 'autores';

    public function libros()
    {
        return $this->hasMany(Libros::class,'autores_id');
    }
}
