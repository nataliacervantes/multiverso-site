<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Eventos extends Model
{
    protected $table = 'eventos';

    public function carrito()
   {
       return $this->belongsTo(Carrito::class);
   }
}
