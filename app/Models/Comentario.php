<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    protected $table = 'comentarios';

    protected $fillable = [
        'id_atraccion',
        'nombre_usuario',
        'calificacion',
        'detalles',
    ];

    public function atraccion()
    {
        return $this->belongsTo(Atraccion::class, 'id_atraccion');
    }
}