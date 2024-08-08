<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atraccion extends Model
{
    use HasFactory;

    protected $table = 'atracciones';
    
    protected $fillable = [
        'titulo',
        'descripcion',
        'id_especie',
    ];

    public function especie()
    {
        return $this->belongsTo(Especie::class, 'id_especie');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'id_atraccion');
    }
}