<?php

namespace App\Http\Controllers;

use App\Models\Ubicacion;
use Illuminate\Http\Request;
use League\CommonMark\Extension\CommonMark\Node\Inline\Strong;

class UbicacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ubicaciones=Ubicacion::all();
        return view('ubicaciones',['ubicaciones'=>$ubicaciones]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ubicaciones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $datosValidos = $request->validate([
            'nombre' => 'required|min:4|max:50',
            'descripcion' => 'required',
            'dias.*' => ['required', 'distinct', 'in:L,M,X,J,V,S,D']
        ]);

        $ubicacion = new Ubicacion;
        $ubicacion->nombre = $datosValidos['nombre'];
        $ubicacion->descripcion = $datosValidos['descripcion'];
        //Array pasado a string separado por comas.
        $ubicacion->dias = implode(',', $datosValidos['dias']); 
        $ubicacion->save();

        return redirect('ubicaciones')->with('ok', 'La ubicación se ha creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ubicacion $ubicacion)
    {
        $talleres = $ubicacion->talleres;

        return view('ubicaciones.detalleubicacion')->with('ubicacion', $ubicacion)->with('talleres', $talleres);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ubicacion $ubicacion)
    {
        return view('ubicaciones.edit')->with('ubicacion', $ubicacion);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ubicacion $ubicacion)
    {
        $datosValidos = $request->validate([
            'nombre' => 'required|min:4|max:50',
            'descripcion' => 'required',
            'dias.*' => ['required', 'distinct', 'in:L,M,X,J,V,S,D']
        ]);

        $ubicacion->nombre = $datosValidos['nombre'];
        $ubicacion->descripcion = $datosValidos['descripcion'];
        //Array pasado a string separado por comas.
        $ubicacion->dias = implode(',', $datosValidos['dias']); 
        $ubicacion->save();

        return redirect('ubicaciones')->with('ok', 'La ubicación se ha modificado correctamente.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroyconfirm (Ubicacion $ubicacion)
    {
        return view('ubicaciones.destroyconfirm')->with('ubicacion', $ubicacion);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Ubicacion $ubicacion)
    {
        if($request->has('borrar') && $request->borrar == 'si'){

            if($ubicacion->talleres()->exists()){
                $talleres = $ubicacion->talleres()->get();
                foreach($talleres as $taller){
                    $taller->delete();
                }
            }

            $ubicacion->delete();

            return redirect('ubicaciones')->with('ok', 'La ubicación: ' . $ubicacion->nombre . ' con id: ' . $ubicacion->id . ', se ha borrado correctamente.');

        }else{
            return redirect('ubicaciones');
        }
    }
}
