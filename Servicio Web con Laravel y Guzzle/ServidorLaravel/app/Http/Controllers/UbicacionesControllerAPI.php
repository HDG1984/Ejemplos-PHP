<?php

namespace App\Http\Controllers;

use App\Models\Taller;
use Illuminate\Http\Request;
use App\Models\Ubicacion;

class UbicacionesControllerAPI extends Controller
{
    public function listar()
    {
        $ubicaciones = Ubicacion::all(['id', 'nombre', 'descripcion', 'dias']);

        return response()->json($ubicaciones);
    }

    public function talleres(int $idubicacion)
    {
        $ubicacion = Ubicacion::find($idubicacion);

        if(!$ubicacion){
            return response()->json(['Error' => 'Ubicación inexistente'], 404);
        }else{  
            $talleres = Taller::where('ubicacion_id', $idubicacion)->get(['nombre', 'descripcion', 'dia_semana', 'hora_inicio', 'hora_fin', 'cupo_maximo','ubicacion_id']);
        }

        if($talleres->isEmpty()){
            $talleres = [];
        }

        return response()->json($talleres);

    }
}
