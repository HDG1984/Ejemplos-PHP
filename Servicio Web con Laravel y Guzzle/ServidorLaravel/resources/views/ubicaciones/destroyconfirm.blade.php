@extends('layouts.base')
@section('titulo','Confirmar borrado')
@section('content')
    @if(session('ok'))
        <div class="correcto">
            {{ session('ok') }}
        </div>
        <hr>
    @endif
    <h2>Confirmar eliminación</h2>
    <form action="{{route('borradoconfirm', ['ubicacion'=>$ubicacion])}}" method="post" class="formulario">
        @csrf 
        <p>Confirmar para borrar la ubicación: <strong>{{$ubicacion->nombre}}</strong> con id: <strong>{{$ubicacion->id}}</strong> y sus talleres.</p>
        <input type="radio" id="si" name="borrar" value="si">
        <label for="si">Sí, borrar ubicación y sus talleres.</label><br>
        <input type="radio" id="no" name="borrar" value="no" checked>
        <label for="no">No borrar ubicación. </label><br>
        <br>
        <input type="submit" value="Eliminar Ubicación">
    </form>

@endsection