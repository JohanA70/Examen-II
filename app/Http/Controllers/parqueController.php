<?php

namespace App\Http\Controllers;

use App\Models\Atraccion;
use App\Models\Comentario;
use Illuminate\Http\Request;

class ParqueController extends Controller
{
    public function getComentariosByRating($minRating, $maxRating)
    {
        
        $comentarios = Comentario::whereBetween('calificacion', [$minRating, $maxRating])
            ->get(['nombre_usuario','detalles']); // Ajusta según los campos necesarios

        return response()->json($comentarios);
    }

    public function getComentariosCountByAtraccion($atraccionId)
    {
        $count = Comentario::where('id_atraccion', $atraccionId)->count();

        return response()->json(['cantidad' => $count]);
    }

    public function getAtraccionesByEspecie($especieId)
    {
        $atracciones = Atraccion::where('id_especie', $especieId)
            ->get(['titulo', 'descripcion']); 

        return response()->json($atracciones);
    }

    public function getAvgRatingByEspecie($especieId)
    {
        
        $avgRating = Atraccion::where('id_especie', $especieId)
            ->with('comentarios') 
            ->get()
            ->pluck('comentarios')
            ->flatten()
            ->avg('calificacion');

        return response()->json(['especieId' => $especieId, 'avgRating' => $avgRating]);
    }
}
