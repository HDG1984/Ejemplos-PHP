<?php

namespace App\Http\Controllers;

use App\Models\Taller;
use App\Models\Ubicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TalleresControllerAPI extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(int $idubicacion, Request $request)
    {
        $ubicacion = Ubicacion::find($idubicacion);

        if(!$ubicacion){
            return response()->json(['Error' => 'Ubicación inexistente'], 404);
        }

        $datosValidos = Validator::make($request->only(['nombre', 'descripcion', 'dia_semana', 'hora_inicio', 'hora_fin', 'cupo_maximo']) ,
        [
            'nombre'=>'string|required|min:5|max:50',
            'descripcion'=>'string|required',
            'dia_semana'=>'required|in:' . $ubicacion->dias,
            'hora_inicio'=>'required|date_format:H:i',
            'hora_fin'=>'required|date_format:H:i|after:hora_inicio',
            'cupo_maximo'=>'integer|required|min:5|max:30'
        ]
        );

        $datosValidos->setCustomMessages([
            'nombre.required'=>'El nombre no se ha proporcionado.',
            'nombre.min'=>'El nombre debe tener mínimo 5 caracteres.',
            'nombre.max'=>'El nombre debe tener como máximo 50 caracteres.',
            'descripcion.required'=>'La :attribute no se ha proporcionado.',
            'dia_semana.required'=>'El :attribute no se ha proporcionado.',
            'dia_semana.in'=>'El :attribute debe ser (' . $ubicacion->dias . ')',
            'hora_inicio.required'=>'La :attribute no se ha proporcionado.',
            'hora_inicio.date_format'=>'La :attribute no es correcta.',
            'hora_fin.required'=>'La :attribute no se ha proporcionado.',
            'hora_fin.date_format'=>'La :attribute no es correcta.',
            'hora_fin.after'=>'La :attribute es anterior a la hora de inicio',
            'cupo_maximo.integer'=>'El :attribute debe ser un número.',
            'cupo_maximo.required'=>'El :attribute no se ha proporcionado.',
            'cupo_maximo.min'=>'El :attribute debe estar entre 5 y 30',
            'cupo_maximo.max'=>'El :attribute debe estar entre 5 y 30'
        ]);

        $datosValidos->setAttributeNames([
            'descripcion'=>'descripción',
            'dia_semana'=>'día de la semana',
            'hora_inicio'=>'hora de inicio',
            'hora_fin'=>'hora final',
            'cupo_maximo'=>'cupo máximo'
        ]);

        if($datosValidos->fails())
        {
            return response()->json(
                ['resultado'=>'error','errores'=>$datosValidos->errors()],422
            );
        }

        $nuevoTaller = Taller::create($datosValidos->validate() + ['ubicacion_id'=>$idubicacion]);
        return response()->json(['resultado'=>'ok','datos'=>$nuevoTaller],200);


    }

   

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $taller = Taller::find($id);

        if(!$taller){
            return response()->json(['resultado' => 'Ubicación inexistente'], 404);
        }

        $taller->delete();

        return response()->json(['resultado'=>'Taller con id: ' . $id . ' eliminado'], 200);
        
    }

    public function cambiarUbicacion(int $idtaller, Request $request)
    {
        $taller = Taller::find($idtaller);

        if(!$taller){
            return response()->json(['resultado' => 'Taller inexistente'], 404);
        }

        if(!$request->isJson()){
            return response()->json(['resultado' => 'El formato de datos recibido no es el esperado, se espera JSON'], 422);
        }

        if(!$request->has('id_nueva_ubicacion')){
            return response()->json(['resultado' => 'El documento JSON no contiene los datos esperados.'], 422);
        }

        $datos = $request->json()->all();

        $ubicacion = Ubicacion::find($datos['id_nueva_ubicacion']);

        if(!$ubicacion){
            return response()->json(['resultado' => 'Nueva ubicación no válida o inexistente'], 422);
        }

        $diasUbicacionDisponible = explode(',', $ubicacion['dias']);
        
        if(!in_array($taller['dia_semana'], $diasUbicacionDisponible)){
            return response()->json(['resultado' => 'La ubicación no está disponible el día del taller'], 409);
        }

        $taller->ubicacion_id = $ubicacion->id;
        $taller->save();

        return response()->json(['resultado'=>'El taller con id: ' . $idtaller . 
                ' ha sido cambiado a la ubicación con id:' . $ubicacion->id . ' (' . $ubicacion->nombre . ')'],
                200
        );

    }
}
