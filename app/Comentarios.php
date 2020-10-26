<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comentarios extends Model
{
    protected $table = "comentarios";

    public function Libro()
    {
        return $this->belongsTo(Libros::class, 'foreign_key', 'other_key');
    }
}
