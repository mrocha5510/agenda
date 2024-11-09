<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    use HasFactory;

    protected $table = 'contacto';

    protected $fillable = [
        'nombre',
        'nota',
        'fecha_cumpleanios',
        'pagina_web',
        'empresa',
        'telefono',
        'email',   
        'direccion'     
    ];
}
