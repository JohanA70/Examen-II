<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;  // Importar la clase User
use App\Models\Especie;  // Importar la clase Especie
use App\Http\Resources\ComentariosResource;  // Importar la clase ComentariosResource
use Illuminate\Http\Request;

class UserComentariosController extends Controller
{
    public function index(User $user){
        $especies = Especie::all();
        return ComentariosResource::collection($especies);
    }
}
