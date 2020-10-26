<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    protected $table = 'infousuario';

    protected $fillable = [
        'Nombre',
        'Apellido',
        'Domicilio',
        'Colonia',
        'CP',
        'Ciudad',
        'Estado',
        'Telefono',
        'Email',
    ]
}
