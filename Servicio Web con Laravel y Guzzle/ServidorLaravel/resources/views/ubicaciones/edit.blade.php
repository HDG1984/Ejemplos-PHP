@extends('layouts.base')
@section('titulo','Modificar ubicación')
@section('content')

    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        <hr>
    @endif

    <h2>Editar ubicación</h2>
    <form action="{{route('ubi', ['ubicacion'=>$ubicacion])}}" method="post" class="formulario">
        @csrf 
        Nombre: <input type="text" name="nombre" value="{{$ubicacion->nombre}}"><br>
        Descripción: <input type="text" name="descripcion" value="{{$ubicacion->descripcion}}"><br>
        Días en los que está disponible:<br>
        
        @foreach (['L','M','X','J','V','S','D'] as $dia)
            {{$dia}} <input type="checkbox" name='dias[]' value="{{$dia}}"  {{in_array($dia, explode(',', $ubicacion->dias)) ? 'checked' : ''}}>
        @endforeach
        <br>
        <input type="submit" value="Modificar Ubicación">
    </form>
@endsection
