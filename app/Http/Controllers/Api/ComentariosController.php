<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Especie;
use App\Models\Atraccion;
use App\Models\Comentario;
use Illuminate\Http\Request;
use App\Http\Resources\ComentariosResource;
use App\Http\Resources\EspecieResource;

class ComentariosController extends Controller
{
    public function index()
    {
        $especies = Especie::all();
        return response()->json($especies);
    }

    public function save(Request $request)
    {
        $request->validate([
            'id_atraccion' => 'required|exists:atracciones,id',
            'nombre_usuario' => 'required|string|max:50',
            'calificacion' => 'required|integer|min:1|max:5',
            'detalles' => 'nullable|string|max:100',
        ]);

        $comentario = Comentario::create([
            'id_atraccion' => $request->id_atraccion,
            'nombre_usuario' => $request->nombre_usuario,
            'calificacion' => $request->calificacion,
            'detalles' => $request->detalles,
        ]);

        return response()->json($comentario, 201);
    }


    // Obtener la Especie de una Atracción dada
    public function obtenerEspecies($id)
    {
        $atraccion = Atraccion::findOrFail($id);
        $especie = $atraccion->especie;

        return response()->json($especie);
    }

    // Editar Atracción
    public function updateAtraccion(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:50',
            'descripcion' => 'required|string|max:50',
            'id_especie' => 'required|exists:especies,id',
        ]);

        $atraccion = Atraccion::findOrFail($id);
        $atraccion->update([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'id_especie' => $request->id_especie,
        ]);

        return response()->json($atraccion);
    }
}
