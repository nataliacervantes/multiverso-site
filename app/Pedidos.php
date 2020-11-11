<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedidos extends Model
{
    protected $table = 'pedidos';

    protected $fillable=[
        'Nombre',
        'Apellido',
        'Domicilio',
        'Colonia',
        'CP',
        'Estado',
        'Ciudad',
        'Pais',
        'Telefono',
        'Email',
        'Total',
        'Envio',
    ];
}
