<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    protected $table = 'carrito';

    public function books()
    {
        return $this->belongsTo(Libros::class);
    }

    public function eventos()
    {
        return $this->belongsTo(Eventos::class);
    }
}
